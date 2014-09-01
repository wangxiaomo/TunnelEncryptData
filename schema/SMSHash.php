<?php
/**
 * @Entity
 * @Table(name="sxjj_sms_hash",
        indexes={@Index(name="idx_hash", columns={"hash"})}
   )
 */
class SMSHash {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $type;
    /** @Column(type="string") **/
    protected $mobile;
    /** @Column(type="string") **/
    protected $hash;
    /** @Column(type="datetime") **/
    protected $creation_time;

    use common_mixin;
    use sms_hash_mixin;
}
