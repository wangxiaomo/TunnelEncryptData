<?php
/**
 * @Entity
 * @Table(name="sxjj_driver_info",
        indexes={@Index(name="idx_jszh", columns={"jszh"})},
        uniqueConstraints={@UniqueConstraint(name="unq_jszh", columns={"jszh"})}
   )
 */
class Driver implements TunnelInterface {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $mobile;
    /** @Column(type="datetime") **/
    protected $creation_time;
    /** @Column(type="string") **/
    protected $jszh;
    /** @Column(type="string") **/
    protected $token;

    use tunnel;
    use common_mixin;
    use driver_mixin;

    public function refreshToken(){
        $name = $this->decrypt($this->name);
        $mobile = $this->decrypt($this->mobile);
        $jszh = $this->decrypt($this->jszh);

        $this->token = uniqid();
        $this->name = $this->encrypt($name);
        $this->mobile = $this->encrypt($mobile);
        $this->jszh = $this->encrypt($jszh);
    }
}
