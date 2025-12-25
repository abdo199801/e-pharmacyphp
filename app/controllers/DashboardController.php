<?php
class DashboardController extends Controller {
    
    // ... (keep your existing constructor and methods)

    public function products() {
        $clientId = $_SESSION['client_id'];
        $action = $_GET['action'] ?? 'list';
        
        switch ($action) {
            case 'create':
                $this->createProduct($clientId);
                break;
            case 'edit':
                $this->editProduct($clientId);
                break;
            case 'delete':
                $this->deleteProduct($_GET['id'], $clientId);
                break;
            case 'toggle-status':
                $this->toggleProductStatus($_GET['id'], $_GET['status'], $clientId);
                break;
            case 'export':
                $this->exportProducts($clientId);
                break;
            case 'import':
                $this->importProducts($clientId);
                break;
            case 'bulk-action':
                $this->handleBulkAction($clientId);
                break;
            default:
                $this->listProducts($clientId);
                break;
        }
    }

    private function listProducts($clientId) {
        try {
            $includeInactive = isset($_GET['show_inactive']) && $_GET['show_inactive'] == '1';
            $search = $_GET['search'] ?? '';
            $category = $_GET['category'] ?? '';
            $status = $_GET['status'] ?? '';
            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = 10;
            
            $dashboardId = $this->dashboardModel->getClientDashboardId($clientId);
            
            // Get filtered products
            $filters = [
                'search' => $search,
                'category_id' => $category,
                'status' => $status === 'all' ? '' : $status,
                'limit' => $perPage,
                'offset' => ($page - 1) * $perPage
            ];
            
            $products = $this->productModel->getClientProducts($clientId, true, $filters);
            $totalProducts = $this->productModel->getClientProductsCount($clientId, $filters);
            $totalPages = ceil($totalProducts / $perPage);
            
            $data = [
                'title' => 'Manage Products - Dashboard',
                'products' => $products,
                'categories' => $this->productModel->getAllCategories(),
                'dashboard_id' => $dashboardId,
                'current_action' => 'list',
                'include_inactive' => $includeInactive,
                'search' => $search,
                'selected_category' => $category,
                'selected_status' => $status,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => $totalPages,
                    'per_page' => $perPage,
                    'total_items' => $totalProducts
                ]
            ];
            
            $this->view->render('dashboard/products', $data);
            
        } catch (Exception $e) {
            error_log("Products listing error: " . $e->getMessage());
            $_SESSION['error'] = 'Error loading products.';
            header('Location: ' . BASE_URL . 'dashboard/products');
            exit;
        }
    }

    private function exportProducts($clientId) {
        try {
            $format = $_GET['format'] ?? 'csv';
            $filters = [
                'search' => $_GET['search'] ?? '',
                'category_id' => $_GET['category'] ?? '',
                'status' => $_GET['status'] ?? ''
            ];
            
            $exportResult = $this->productModel->exportProducts($clientId, $format, $filters);
            
            if ($exportResult) {
                // Set headers for download
                header('Content-Type: ' . $exportResult['content_type']);
                header('Content-Disposition: attachment; filename="' . $exportResult['filename'] . '"');
                header('Content-Length: ' . filesize($exportResult['filepath']));
                
                readfile($exportResult['filepath']);
                
                // Clean up
                unlink($exportResult['filepath']);
                exit;
            } else {
                throw new Exception("Export failed");
            }
            
        } catch (Exception $e) {
            error_log("Export error: " . $e->getMessage());
            $_SESSION['error'] = 'Failed to export products.';
            header('Location: ' . BASE_URL . 'dashboard/products');
            exit;
        }
    }

    private function importProducts($clientId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!isset($_FILES['import_file']) || $_FILES['import_file']['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("Please select a valid file to import.");
                }
                
                $file = $_FILES['import_file'];
                $format = pathinfo($file['name'], PATHINFO_EXTENSION);
                
                // Validate file type
                $allowedFormats = ['csv', 'xlsx', 'xls'];
                if (!in_array($format, $allowedFormats)) {
                    throw new Exception("Please upload a CSV or Excel file.");
                }
                
                // Validate file size (max 10MB)
                if ($file['size'] > 10 * 1024 * 1024) {
                    throw new Exception("File size must be less than 10MB.");
                }
                
                $uploadPath = 'uploads/imports/' . uniqid() . '_' . $file['name'];
                if (!is_dir('uploads/imports')) {
                    mkdir('uploads/imports', 0755, true);
                }
                
                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    throw new Exception("Failed to upload file.");
                }
                
                $importResult = $this->productModel->importProducts($clientId, $uploadPath, $format);
                
                // Clean up uploaded file
                unlink($uploadPath);
                
                if ($importResult) {
                    $message = "Successfully imported {$importResult['imported']} out of {$importResult['total']} products.";
                    
                    if (!empty($importResult['errors'])) {
                        $message .= " Errors: " . implode(', ', array_slice($importResult['errors'], 0, 5));
                        if (count($importResult['errors']) > 5) {
                            $message .= " and " . (count($importResult['errors']) - 5) . " more errors.";
                        }
                    }
                    
                    $_SESSION['success'] = $message;
                } else {
                    throw new Exception("Import failed.");
                }
                
            } catch (Exception $e) {
                error_log("Import error: " . $e->getMessage());
                $_SESSION['error'] = $e->getMessage();
            }
            
            header('Location: ' . BASE_URL . 'dashboard/products');
            exit;
        } else {
            // Show import form
            $this->showImportForm($clientId);
        }
    }

    private function showImportForm($clientId) {
        try {
            $dashboardId = $this->dashboardModel->getClientDashboardId($clientId);
            
            $data = [
                'title' => 'Import Products - Dashboard',
                'dashboard_id' => $dashboardId,
                'current_action' => 'import'
            ];
            
            $this->view->render('dashboard/product_import', $data);
            
        } catch (Exception $e) {
            error_log("Import form error: " . $e->getMessage());
            $_SESSION['error'] = 'Error loading import form.';
            header('Location: ' . BASE_URL . 'dashboard/products');
            exit;
        }
    }

    private function handleBulkAction($clientId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $action = $_POST['bulk_action'] ?? '';
                $productIds = $_POST['product_ids'] ?? [];
                
                if (empty($productIds)) {
                    throw new Exception("No products selected.");
                }
                
                switch ($action) {
                    case 'activate':
                        $this->productModel->bulkUpdateStatus($clientId, $productIds, 'active');
                        $_SESSION['success'] = count($productIds) . ' products activated successfully.';
                        break;
                        
                    case 'deactivate':
                        $this->productModel->bulkUpdateStatus($clientId, $productIds, 'inactive');
                        $_SESSION['success'] = count($productIds) . ' products deactivated successfully.';
                        break;
                        
                    case 'delete':
                        $this->productModel->bulkDelete($clientId, $productIds);
                        $_SESSION['success'] = count($productIds) . ' products deleted successfully.';
                        break;
                        
                    default:
                        throw new Exception("Invalid bulk action.");
                }
                
            } catch (Exception $e) {
                error_log("Bulk action error: " . $e->getMessage());
                $_SESSION['error'] = $e->getMessage();
            }
        }
        
        header('Location: ' . BASE_URL . 'dashboard/products');
        exit;
    }

    // ... (keep your existing create, edit, delete methods)
}
?>