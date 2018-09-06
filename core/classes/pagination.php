<?php

	class Pagination
	{
		public function __construct()
		{
		}
		
		public function display($list, $max = 20)
        {
            if (ADMIN_PANEL)
            {
                $link = str_replace(SUBFOLDER, "", str_replace("&p=". $_GET["p"], "", $_SERVER["REQUEST_URI"])."&");
            }
            else
            {
                $link = str_replace(SUBFOLDER, "", str_replace("&p=". $_GET["p"], "", $_SERVER["REQUEST_URI"]));
                if (!strpos($link, "?"))
                {
                    $link .= "?";
                }
                else
                {
                    $link .= "&";
                }
            }
            if ($link[0] == "/")
            {
                $link = substr($link, 1);
            }
            if (!ADMIN_PANEL)
            {
                $link = Core::route($link);
            }
            else
            {
                $link = str_replace("admin/", "", $link);
            }
            $page = ($_GET["p"] > 0 ? $_GET["p"] : 1);
            $highest = ceil($list / $max);
            if ($list > $max && $page > 0)
            {
                $string = '<div class="btn-group" style="margin-bottom: 20px; margin-top: 20px; float: right;">';
                    if ($page > 1)
                    {
                        $string .= '<a href="'. $link .'p=1" class="btn btn-dark"><i class="fa fa-angle-double-left"></i></a>';
                        $string .= '<a href="'. $link .'p='. ($page - 1) .'" class="btn btn-dark"><i class="fa fa-angle-left"></i></a>';
                    }
                    else
                    {
                        $string .= '<a href="#" class="btn btn-dark" disabled="disabled"><i class="fa fa-angle-double-left"></i></a>';
                        $string .= '<a href="#" class="btn btn-dark" disabled="disabled"><i class="fa fa-angle-left"></i></a>';
                    }
                    if ($page > 2)
                    {
                        $string .= '<a href="'. $link .'p='. ($page - 2) .'" class="btn btn-dark">'. ($page - 2) .'</a>';
                    }
                    if ($page > 1)
                    {
                        $string .= '<a href="'. $link .'p='. ($page - 1) .'" class="btn btn-dark">'. ($page - 1) .'</a>';
                    }
                    $string .= '<a href="'. $link .'p='. $page .'" class="btn btn-dark" disabled="disabled">'. $page .'</a>';
                    if ($page <= ($highest - 1))
                    {
                        $string .= '<a href="'. $link .'p='. ($page + 1) .'" class="btn btn-dark">'. ($page + 1) .'</a>';
                    }
                    if ($page < ($highest - 2))
                    {
                        $string .= '<a href="'. $link .'p='. ($page + 2) .'" class="btn btn-dark">'. ($page + 2) .'</a>';
                    }

                    if ($page != $highest)
                    {
                        if ($page <= ($highest - 1))
                        {
                            $string .= '<a href="'. $link .'p='. ($page + 1) .'" class="btn btn-dark"><i class="fa fa-angle-right"></i></a>';
                        }
                        $string .= '<a href="'. $link .'p='. $highest .'" class="btn btn-dark"><i class="fa fa-angle-double-right"></i></a>';
                    }
                    else
                    {
                        $string .= '<a href="#" class="btn btn-dark" disabled="disabled"><i class="fa fa-angle-right"></i></a>';
                        $string .= '<a href="#" class="btn btn-dark" disabled="disabled"><i class="fa fa-angle-double-right"></i></a>';
                    }
                $string .= '</div><div class="clearfix"></div>';
            }
            echo $string;
        }
		
	}

?>