<?
require_once("twitter.lib.php");


$twitter=InputAndLoginToTwitter();
echo "Enter Tag : ";
$tag = fgets (STDIN, 1024);


while(1)
{
	print "Update  : ";
	$stdin = fgets (STDIN, 1024); 
	$update=$twitter->updateStatus(trim((string)$stdin) . " " . trim($tag));
		if($twitter->http_status!=200)
		{
			$error_code=$twitter->http_status;
			$xml = new SimpleXMLElement($update);
			printf("ERROR %d : %s\n",$error_code,$xml->error);			
			if($error_code==401) // Could not authenticate you.
			{
				$twitter=InputAndLoginToTwitter();
			}
			else
			{
				exit($error_code);
			}
		}
		else
		{
			echo "Update Completed!\n";
		}
}
function InputAndLoginToTwitter()
{
	echo "Enter Username : ";
	$username = fgets (STDIN, 1024); 
	echo "Enter Password : ";
	$password = fgets (STDIN, 1024);
	return $twitter = new Twitter(trim($username),trim($password));		
}
?>
