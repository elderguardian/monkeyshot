<?php

class ViewController extends Controller
{

    private function renderString(string $toRender, string $fileName) : string {
        $rendered = $toRender;

        $filePath = "static/$fileName";

        if (str_contains($toRender, '$fileSizeMb')) {
            $bytes = max(filesize($filePath), 0);
            $mb = round($bytes / 1024 / 1024,2);

            $rendered = str_replace('$fileSizeMb', $mb, $rendered);
        }

        if (str_contains($toRender, '$fileName')) {
            $rendered = str_replace('$fileName', $fileName, $rendered);
        }

        return $rendered;
    }

    public function index(IKernel $kernel)
    {
        $request = $kernel->get('IRequest');
        $image = $request->fetch('i');

        if (!$image) {
            return $this->view('error', [
                'message' => 'No image parameter given.'
            ]);
        }

        $filePath = "static/$image";
        $imageExists = file_exists($filePath);

        if (!$imageExists) {
            return $this->view('error', [
                'message' => 'Could not find this image.'
            ]);
        }

        $config = include('config.php');

        return $this->view('image', [
            'baseUrl' => $config['base_url'],
            'title' => $this->renderString($config['embed_title'], $image),
            'description' => $this->renderString($config['embed_description'], $image),
            'color' => $config['embed_color'],
            'imageUrl' => "/$filePath",
            'fileName' => $image,
        ]);
    }

}