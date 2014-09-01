<?php
/**
 * @Entity
 * @Table(name="sxjj_car_info",
        indexes={@Index(name="idx_hphm_and_hpzl", columns={"hphm", "hpzl"})},
        uniqueConstraints={@UniqueConstraint(name="unq_hphm_and_hpzl", columns={"hphm", "hpzl"})}
   )
 */
class Car implements TunnelInterface {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;
    /** @Column(type="string") **/
    protected $mobile;
    /** @Column(type="datetime") **/
    protected $creation_time;
    /** @Column(type="string") **/
    protected $hphm;
    /** @Column(type="string") **/
    protected $hpzl;
    /** @Column(type="string") **/
    protected $token;

    use tunnel;
    use common_mixin;
    use car_mixin;

    public function refreshToken(){
        $name = $this->decrypt($this->name);
        $mobile = $this->decrypt($this->mobile);
        $hpzl = $this->decrypt($this->hpzl);
        $hphm = $this->decrypt($this->hphm);

        $this->token = uniqid();
        $this->name = $this->encrypt($name);
        $this->mobile = $this->encrypt($mobile);
        $this->hpzl = $this->encrypt($hpzl);
        $this->hphm = $this->encrypt($hphm);
    }
}
