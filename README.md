# Fa-GD
This Library forked from [PersianRender](https://github.com/mahmoud-eskandari/PersianRender)


# Installation

## Using Composer

You can install this package using [composer](https://getcomposer.org). Add this package to your `composer.json`:  

```
"require": {
	"patriotblog/fa-gd": "dev-master"
}
```

# manual

```

 \FaGD\PPersianRender::render('کتابخانه ی رندر GD image در php');

```

using in the Gd image
```

  $text  = \FaGD\PPersianRender::render('فارسی',true); //Reversed text for GD
  
  imagettftext ( $image ,  $size ,  $angle , $x , $y ,$color , $fontfile , $text );
  
```
