<?php
/**
 * @Entity
 * @Table(name="sxjj_sms_log")
 */
class SMSLog implements TunnelInterface {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $mobile;
    /** @Column(type="string") **/
    protected $content;
    /** @Column(type="string") **/
    protected $token;
    /** @Column(type="datetime") **/
    protected $send_time;

    use tunnel;
    use common_mixin;
    use sms_mixin;

    public function refreshToken(){
        $mobile = $this->decrypt($this->mobile);
        $content = $this->decrypt($this->content);

        $this->token = uniqid();
        $this->mobile = $this->encrypt($mobile);
        $this->content = $this->encrypt($content);
    }
}
