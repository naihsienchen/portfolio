<?php
        //Function used to create navigation menu
        function displayNavigation(array $menu, $class = "menu")
        {
                $htmlMenu = "<div class='$class'><ul>";
                
                foreach ($menu as $name => $link)
                {
                        $htmlMenu .= "<li><a href='$link'>$name</a></li>";
                }

                $htmlMenu .= "</ul></div>";
                return $htmlMenu;
        }
?> 