<?php namespace App\Repositories;

class MyHelper {
	/**
	 * 我的资源请求路径，为了链到 腾讯云，重写辅助函数 elixir
	 * @author @smallnews 2017-06-03
	 * @param  [type] $file           [description]
	 * @param  string $buildDirectory [description]
	 * @param  string $assetDriectory [description]
	 * @return [type]                 [description]
	 */
	public function elixir($file, $buildDirectory = 'build', $assetDriectory = 'asset')
    {
        static $manifest = [];
        static $manifestPath;

        if (empty($manifest) || $manifestPath !== $buildDirectory) {
            $path = public_path($buildDirectory.'/rev-manifest.json');

            if (file_exists($path)) {
                $manifest = json_decode(file_get_contents($path), true);
                $manifestPath = $buildDirectory;
            }
        }

        if (isset($manifest[$file])) {
            return trim(config('app.asset_url').'/'.$assetDriectory.'/'.$manifest[$file], '/');
        }

        $unversioned = public_path($file);

        if (file_exists($unversioned)) {
            return '/'.trim($file, '/');
        }

        abort(404);
    }
	
	
}
