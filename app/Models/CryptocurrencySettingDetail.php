<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptocurrencySettingDetail extends Model
{
    use HasFactory;

    protected $table = 'mg_cryptocurrency_setting_detail';

    protected $primaryKey = 'ccsd_id';

    protected $fillable = [
        'ccsd_id',
        'ccs_id',
        'ccsd_image',
        'ccsd_explan',
        'ccsd_total_raise',
        'ccsd_soft_cap',
        'ccsd_raise_status',
        'ccsd_mini_invest',
        'ccsd_approve_invest',
        'ccsd_sec_type',
        'ccsd_exemption',
        'ccsd_organization',
        'ccsd_token_price',
        'ccsd_token_issuer',
        'ccsd_token_protocol',
        'ccsd_token_issuer_info',
        'ccsd_payment_option',
        'ccsd_token_rights',
    ];
}
