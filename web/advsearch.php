<?php
#INCLUDE THE FOLLOWING TO MAKE THE REST WORK#
include_once 'config.php';
include_once 'vars.php';

##########CONNECTION INFO FOR DATABASE###########
$con = new mysqli($ip,$user,$pw,$db);
############STARTING CONTENT#############

#CODE FOR SEARCHING DATABASE AND PRINTING RESULTS#
if(isset($_GET["min"])) {
?>    
<html>
	<!-- Initalize Page -->
	<head>
		<title>SHU-Explorer - Advanced Search</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="main">
			<?php echo file_get_contents('header.html') . "</br>"; 
			if($alert_text != ""){
				echo $widget_webpage_alert;
			}
			
			echo $webpage_topcontentbox;
			?>
			
	<!-- End Init -->

<?php

	//Variables needed for searching.
    $searchparam_assettag = $_GET["at"]; //Asset Tag
    $searchparam_owner = $_GET["user"];				//
    $searchparam_name = $_GET["name"];

	//Kicks in if no input for the maximum field. 500k is the max. price for MP.
    if($searchparam_owner < 0 OR $searchparam_owner == NULL)
    {
        $searchparam_owner = 5000000;
    }
	//Kicks in if no input for the minimum field.
    if($searchparam_assettag < 0 OR $searchparam_assettag == NULL)
    {
        $searchparam_assettag = 1;
    }
    if($name == NULL)
    {
        $name = ' ';
    }
    
	###########Redo whole section once database is complete.
	
    #GET NAME FROM SEARCH TERMS#
	if($searchparam_assettag != NULL){
		$search_query = mysqli_query($con, "SELECT * FROM Names WHERE LastPrice>='$searchparam_assettag' ORDER BY LastPrice ASC LIMIT 50");
	}
    
    $search_nums = mysqli_num_rows($search_query);
    
    echo '<tr><th><a href="index.php"><img src="img/search.png"></a></th></tr>';
    
    if($search_nums > 0)
    {
		echo '<tr><th><h2>Found '. $search_nums .' items!</h2></th></tr>';
		echo '<tr><th><hr style="border-color:#6D7ACE; width:55%;"></th></tr>';
		while ($obj = mysqli_fetch_object($search_query)) {
			echo "<tr><th><a class='reg' href='item.php?info=" . urlencode($obj->ItemName) . "'>" . $obj->ItemName," (", $obj->LastPrice,"MP)</a><strong> [<a target='_blank' class='reg' href='http://www.marapets.com/shopsearch.php?do=" . $obj->ItemName . "'>Shop Search</a>]</strong>";
			if($obj->SecondaryName != NULL)
			{
				echo "  (" . $obj->SecondaryName . ") </a><br /></th></tr>";
			}
        
		}
    }
	
    //If the user has an amount higher than 500k, let them know why it won't work.
    elseif($searchparam_assettag > 500000)
    { ?>
		<tr>
			<th>
				<h2>Oops!</h2>
			</th>
		</tr>
    <tr><th><hr style="border-color:#6D7ACE; width:55%;"></th></tr>';
    <tr><th>Deprecated error_priceOver500k</th></tr>
	<?php
    }
    elseif($search_nums == 0)
    { ?>
		<tr>
			<th>
				<h2>Deprecated error_nothingFound</h2>
			</th>
		</tr>
		<tr>
			<th>
				<hr style="border-color:#6D7ACE; width:55%;">
			</th>
		</tr>
		<tr>
			<th>Deprecated  error_NothingFound2</th>
		</tr>
	<?php
    } ?>
    <tr>
		<td style="height:20px;">
			</br>
			<a href="javascript:history.go(-1)">Back to Search...</a>
		</td>
	</tr>
<?php
}
else { ?>
<html>
	<!-- Initalize Page -->
	<head>
		<title>SHU-Explorer - Search Assets</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="main">
			<?php echo file_get_contents('header.html') . "</br>"; 
			if($alert_text != ""){
				echo $widget_webpage_alert;
			}
			echo $webpage_topcontentbox;
			?>
	<!-- End Init -->
				<tr>
					<th>
						<a href="index.php">
							<img src="img/search-advanced.png">
						</a>
					</th>
				</tr>
				<tr>
					<th>
						<img src="img/titles/advancedsearch.png">
					</th>
				</tr>
				<tr>
					<td style="height:8px" ></td>
				</tr>
				<tr>
					<th>
					<?php echo "<p>" .$advsearch_desc. "</p></br>"; ?>
					</th>
				</tr>
				<tr>
					<th>
						<form action="advsearch.php" method="get"></br>
							<strong>Asset Tag #: </strong>
							<input type="text" name="assettag" maxlength="5" size="6"></br></br>
							<strong>Device Name: </strong><input type="text" name="dname" maxlength="16" size="18"></br></br>
							<strong>Owner Username: </strong><input type="text" name="duser" maxlength="9" size="10"></br></br>
							<input type="submit" value="Search">
						</form></br></br></br>
					</th>
				</tr>
			</table>
<?php }  ?>
<tr>
	<td style="height:10px"></td>
</tr>
<?php echo $webpage_bottomcontentbox; ?>
</div>
</body>
</html>