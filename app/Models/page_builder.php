<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class page_builder extends Model
{
    use HasFactory;

    public static function get_active_template($id) 
    {
        return optional(self::templates()->where('id', $id))->first();
    }

    public static function convert_base64($path) 
    {
        $extenstion = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $extenstion . ';base64,' . base64_encode($data);
    }

    public static function convert_resource_file($id) 
    {
        $src = request()->file($id)->store('pdf-images', 'public');
        $path = public_path('\/storage/' . $src);
        return self::convert_base64($path);
    }

    public static function templates() 
    {
        return collect([
            [
                'id' => 'template1',
                'name' => 'Template1',
                'template' => [
                    'header' => self::convert_base64(base_path('/public/images/sample-template.png')),
                    'footer' => self::convert_base64(base_path('/public/images/sample-footer-template.png'))
                ]
            ],
            [
                'id' => 'template2',
                'name' => 'Template2',
                'template' => [
                    'header' => self::convert_base64(base_path('/public/images/sample-template-1.png')),
                    'footer' => self::convert_base64(base_path('/public/images/sample-footer-template-1.png'))
                ]
            ],
        ]);
    }

    public static function get_svgs() 
    {
        return [
            'arrow-top' => '<svg width="20" height="30" viewBox="0 0 20 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 29V10" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 11L10 1L19 11" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>',
    
            'egg' => '<svg width="35" height="25" viewBox="0 0 35 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M33 12.5C33 15.1382 31.5063 17.7154 28.7119 19.7114C25.9213 21.7046 21.9637 23 17.5 23C13.0363 23 9.07867 21.7046 6.28811 19.7114C3.49371 17.7154 2 15.1382 2 12.5C2 9.86176 3.49371 7.28463 6.28811 5.28863C9.07867 3.29538 13.0363 2 17.5 2C21.9637 2 25.9213 3.29538 28.7119 5.28863C31.5063 7.28463 33 9.86176 33 12.5Z" stroke="black" stroke-width="4"/>
            </svg>',
    
            'plus-o' => '<svg width="36" height="29" viewBox="0 0 36 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M33 0H3C2.20435 0 1.44129 0.30125 0.87868 0.837478C0.316071 1.37371 0 2.10099 0 2.85933V25.1907C0 25.949 0.316071 26.6763 0.87868 27.2125C1.44129 27.7487 2.20435 28.05 3 28.05C3.76162 28.0459 4.49307 27.7658 5.046 27.2665L9.132 23.5952C9.24265 23.4964 9.38842 23.4413 9.54 23.4408H33C33.7957 23.4408 34.5587 23.1395 35.1213 22.6033C35.6839 22.0671 36 21.3398 36 20.5814V2.85361C35.9984 2.09626 35.6816 1.37045 35.1192 0.835455C34.5568 0.300463 33.7946 -1.5147e-06 33 0ZM33.6 20.5872C33.6 20.7388 33.5368 20.8843 33.4243 20.9915C33.3117 21.0988 33.1591 21.159 33 21.159H9.552C8.78706 21.1587 8.05088 21.4369 7.494 21.9368L3.414 25.6081C3.32876 25.6856 3.2215 25.7374 3.10557 25.7572C2.98964 25.7769 2.87018 25.7637 2.76206 25.7192C2.65395 25.6747 2.56198 25.6008 2.49759 25.5069C2.43321 25.4129 2.39927 25.3029 2.4 25.1907V2.85933C2.4 2.70766 2.46321 2.5622 2.57574 2.45496C2.68826 2.34771 2.84087 2.28746 3 2.28746H33C33.1591 2.28746 33.3117 2.34771 33.4243 2.45496C33.5368 2.5622 33.6 2.70766 33.6 2.85933V20.5872Z" fill="black"/>
                <path d="M21.84 10.9114H19.2V8.3952C19.2 8.09186 19.0735 7.80095 18.8485 7.58646C18.6234 7.37196 18.3182 7.25146 18 7.25146C17.6817 7.25146 17.3765 7.37196 17.1514 7.58646C16.9264 7.80095 16.8 8.09186 16.8 8.3952V10.9114H14.16C13.8417 10.9114 13.5365 11.0319 13.3114 11.2464C13.0864 11.4609 12.96 11.7518 12.96 12.0551C12.96 12.3585 13.0864 12.6494 13.3114 12.8639C13.5365 13.0784 13.8417 13.1989 14.16 13.1989H16.8V15.7437C16.8 16.047 16.9264 16.3379 17.1514 16.5524C17.3765 16.7669 17.6817 16.8874 18 16.8874C18.3182 16.8874 18.6234 16.7669 18.8485 16.5524C19.0735 16.3379 19.2 16.047 19.2 15.7437V13.2275H21.84C22.1622 13.2275 22.4712 13.1055 22.6991 12.8883C22.927 12.6711 23.055 12.3766 23.055 12.0694C23.055 11.7623 22.927 11.4678 22.6991 11.2506C22.4712 11.0334 22.1622 10.9114 21.84 10.9114Z" fill="black"/>
            </svg>'
        ];    
    }

}
