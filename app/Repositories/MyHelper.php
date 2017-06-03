<?php namespace App\Repositories;

class MyHelper {
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

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
