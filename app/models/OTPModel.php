<?php
class OTPModel extends Model {
    protected $table = 'clients';

    public function generateOTP($userId, $email) {
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $this->update($userId, [
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
            'is_verified' => 0
        ]);
        
        return $otp;
    }

    public function verifyOTP($email, $otp) {
        $user = $this->where('email', $email)->first();
        
        if ($user && 
            $user->otp_code === $otp && 
            strtotime($user->otp_expires_at) > time() &&
            $user->is_verified == 0) {
            
            $this->update($user->id, [
                'is_verified' => 1,
                'otp_code' => null,
                'otp_expires_at' => null
            ]);
            
            return $user;
        }
        
        return false;
    }

    public function isOTPExpired($email) {
        $user = $this->where('email', $email)->first();
        return $user && strtotime($user->otp_expires_at) <= time();
    }
}
?>