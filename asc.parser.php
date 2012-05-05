<?php
// POI (Point of Interest) .ASC file reader
// DWTFYW-Do whatever the f*** you want
// Usage : asc.parser.php?file=path/to/my/file.asc
    $fd = @fopen($_GET['file'],"r");
    
    if (!$fd) die("Can't open the file");
    
    $i=1;
	
	$lat='';
	$long='';
	$name='';
	$dept='';
	$desc='';
	$street='';
	$phone='';
    
    while (!feof($fd))
	{
        $line = fgets($fd, 1024);
        if((!$line)||$line[0]==';')
		continue;
        if (!feof($fd))
		{
		$j=0;
		$k=strlen($line);
		$lat='';
		while($j<$k&&$line[$j]!=',')
			{
			$lat.=$line[$j]; $j++;
			}
		if($j<$k&&$line[$j]==',')
			$j++;
		if($j<$k&&$line[$j]==' ')
			$j++;
		$long='';
		while($j<$k&&$line[$j]!=',')
			{
			$long.=$line[$j]; $j++;
			}
		if($j<$k&&$line[$j]==',')
			$j++;
		if($j<$k&&$line[$j]==' ')
			$j++;
		if($j<$k&&$line[$j]=='"')
			{
			$j++;
			while($j<$k&&$line[$j]==' ')
				$j++;
			if($j<$k&&$line[$j]=='[')
				{
				$j++;
				$name='';
				while($j<$k&&$line[$j]!=']')
					{
					$name.=$line[$j]; $j++;
					}
				if($j<$k&&$line[$j]==']')
					$j++;
				}
			while($j<$k&&$line[$j]==' ')
				$j++;
			if($j<$k&&$line[$j]==',')
				$j++;
			$dept='';
			while($j<$k&&is_numeric($line[$j]))
				{
				$dept.=$line[$j]; $j++;
				}
			while($j<$k&&$line[$j]==' ')
				$j++;
			$desc='';
			while($j<$k&&$line[$j]!='>'&&$line[$j]!='"'&&((!isset($_GET['p']))||$line[$j]!='('))
				{
				$desc.=$line[$j]; $j++;
				}
			$street='';
			if($line[$j]=='(')
				{ $j++;
				while($j<$k&&$line[$j]!=')'&&$line[$j]!='>'&&$line[$j]!='"')
					{
					$street.=$line[$j]; $j++;
					}
				}
			while($j<$k&&$line[$j]==' '&&$line[$j]!='>')
				$j++;
			if($j<$k&&$line[$j]=='>')
				{
				$j++;
				$phone='';
				while($j<$k)
					{
					if(is_numeric($line[$j]))
						$phone.=$line[$j];
					$j++;
					}
				}
			}
		}
		echo 'Lat:'.$lat.' Long:'.$long.(isset($name)?' Name:'.$name:'').(isset($dept)?' Dept:'.$dept:'').(isset($desc)?' Desc:'.$desc:'').(isset($phone)?' Phone:'.$phone:''). '<br />';
        $i++;
    }
    
    fclose($fd);
?> 
