<?php 

namespace ExpressPHP\TemplateEngine\Twig;

class Twig {
	
	public function __invoke($options){
		
		return function ($req, $res, $next) use ($options) {
			
			$views = $req->get("views");
			if(is_null($views)){
				return $next(new Error("Views folder not defined"));
			}
			$loader = new \Twig\Loader\FilesystemLoader($views);
			$opt = [];
			if(isset($options["cache"])){
				$opt["cache"] = $options["cache"];
			}
			if(isset($options["debug"])){
				$opt["debug"] = $options["debug"];
			}
			$twig = new \Twig\Environment($loader, $opt);
			
			$twigEngine = function($folder, $name, $obj, $callback){
				try {
					$content = $twig->render($folder."/".$name, $obj);
					$callback($content);
				} catch (\Exception $err) {
					$message = $err->getMessage();
					$callback($message);
				}
			};
			
		}
		
	}
	
}