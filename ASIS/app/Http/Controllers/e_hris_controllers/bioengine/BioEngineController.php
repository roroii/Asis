<?php

namespace App\Http\Controllers\bioengine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rr\Rewards;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Session;


class BioEngineController extends Controller
{

	public function get_settings() {
		return $this->_get_settings();
	}

	public function _get_settings() {
		/***/
		$url_client = url(''); // DATA
		$url_base = "http://localhost:5656"; // FP local address
		/***/
		$result = [
			"api_key" => "5bcade508106dff4ba2078a9058185ad",
			"url_base" => $url_base,
			"url_check" => $url_base . "/check",
			"url_fp_get" => $url_base . "/getfp",
			"url_fp_action" => $url_base . "/action",
			"url_fp_sync_local" => $url_base . "/fpsynclocal",
			"url_fp_sync_local_all" => $url_base . "/fpsynclocalall",
			"url_client" => $url_client,
			"url_client_sync_tolocal" => $url_client . "/dtr/manage/bio/user/fingerprint/data/get",
			"conn_timeout" => "1000",
			"com_interval" => "1000",
			"auto_fp_data_get" => 1,
			"check_result_count_max" => 3,
			"fp_sample_count" => 4,
		];
		/***/
		return $result;
	}

}