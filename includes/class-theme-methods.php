<?php
	if(!class_exists('ThemeMethods')){
		class ThemeMethods {
			public function navigation($items_array, $class) {
				$nav = '<ul class="'. $class . '">';
				
				foreach ($items_array as $item ){
					$nav .= $item['url'] . '">' . $item['text'] . '</a></li>';
				}
				
				$nav .= '</ul>';
				
				return $nav;
			}
			
			public function installs($items_array) {
				
				foreach ($items_array as $item ){
					$installs .= $item['url'] . '">' . $item['text'] . '</a></td>';
				}
				
				return $installs;
			}
		}
	}
	
	$dtm = new ThemeMethods;
?>