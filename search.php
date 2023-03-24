<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Meta Search Engine </title>
    <link rel="stylesheet" href="index.css"/>
</head>
<?php
if (!empty($_GET['query'])) {
    ?>

<body>
<nav>
        <div class="logo">
            <h1> <a href="index.html"><b>Real-time Meta Search</b></a></h1>
        </div>
        <ul>
            <li><a href="#"> Home </a></li>
            <li><a href="#"> About </a></li>
            <button class="sign-btn"> Sign up </button>
        </ul>
    </nav>
    <main>
                <h1> Search Your Queries </h1>
		<form method="get" action="search.php" >
                <input class="search-bar"  name="query"  type="text" value="<?php $query = $_GET['query']; echo $query; ?>">
                <button type="submit" class="search-btn"><img class="search-image" src="mgf_search.svg" alt="search-pic"></button>
    </main>


<?php


	// Get the query from the form
    $query = $_GET['query'];
// Search Bing
$bing_url = "https://www.bing.com/search?q=" . urlencode($query);
$bing_results = file_get_contents($bing_url);
// Remove any CSS or JavaScript from the Bing results
$bing_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $bing_results);
$bing_results = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $bing_results);
// Get the search result links and titles from the Bing results
preg_match_all('/<li class="b_algo"><h2><a href="(.*?)".*?>(.*?)<\/a><\/h2>/', $bing_results, $bing_matches);
$bing_links = $bing_matches[1];
$bing_titles = $bing_matches[2];
// Combine the search result links and titles into an array
$bing_combined_results = array_combine($bing_links, $bing_titles);
// Sort the combined search results by title
asort($bing_combined_results);
$bing_sorted_results = $bing_combined_results;
echo "<br><h3>Real Time Results from  :  </h3><br><br>";
// Display the sorted search results
?>
	<h1>Bing : </h1><form method="get" action="search.php" ><button type="submit"> <b>No Results ? </b> Regenerate  Results from Bing </button></form><br><br>
<?php
foreach ($bing_sorted_results as $link => $title) {
    echo "<a href='$link'>$title</a><br>";
}
echo "<hr>";



  // Google search engine URL
  $google_url = "https://www.google.com/search?q=";

  // Get the query from the form
  $query = $_GET['query'];

  // Encode the query for use in the URL
  $encoded_query = urlencode($query);

  // Build the Google search URL with the encoded query
  $search_url = $google_url . $encoded_query;

  // Get the search results from Google
  $google_sorted_results = file_get_contents($search_url);

  // Remove CSS from the search results
  $google_sorted_results = preg_replace('/<link\s.*?>/i', '', $google_sorted_results);
  $google_sorted_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $google_sorted_results);

  // Remove local host prefix from the links
  $google_sorted_results = str_replace('href="/', 'href="https://www.google.com/', $google_sorted_results);

  // Remove the Google search bar and input box from the search results
  $google_sorted_results = preg_replace('/<div class="KpMaL">.*?<\/div><\/div><div class="A8SBwf">/', '', $google_sorted_results);

  // Display the combined and sorted search results
  echo "<br><br><br><h1>Google:</h1><br>";
  echo $google_sorted_results;







    // Search Yahoo
    $yahoo_url = "https://in.search.yahoo.com/search?p=" . urlencode($query);
    $yahoo_results = file_get_contents($yahoo_url);
    if (strpos($yahoo_results, 'No results found for') !== false) {
        echo "Yahoo<br>No results found.<br>";
        $yahoo_sorted_results = array();
    } else {
        // Remove any CSS or JavaScript from the Yahoo results
        $yahoo_results = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $yahoo_results);
        $yahoo_results = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $yahoo_results);
        // Get the search result links and titles from the Yahoo results
        preg_match_all('/<a href="(.*?)".*?>(.*?)<\/a>/', $yahoo_results, $yahoo_matches);
        $yahoo_links = $yahoo_matches[1];
        $yahoo_titles = $yahoo_matches[2];
        // Combine the search result links and titles into an array
        $yahoo_combined_results = array_combine($yahoo_links, $yahoo_titles);
        // Sort the combined search results by title
        asort($yahoo_combined_results);
        $yahoo_sorted_results = $yahoo_combined_results;
        echo "<br><br><br><h1>Yahoo</h1><br>";
        // Display the sorted search results without the local host prefix
        foreach ($yahoo_sorted_results as $link => $title) {
          
            echo "<a href='$link'>$title</a><br>";
        }
        echo "<hr>";
    }
}
else{
    ?>
    <nav>
    <div class="logo">
        <h1> <a href="index.html"><b>Real-time Meta Search</b></a></h1>
    </div>
    <ul>
        <li><a href="#"> Home </a></li>
        <li><a href="#"> About </a></li>
        <button class="sign-btn"> Sign up </button>
    </ul>
</nav>
<main>
    <div class="search">
        <div class="title">
            <h1> Search Your Queries </h1>
        </div>
        <div class="search-box">
    <form method="get" action="search.php">
            <input class="search-bar"  name="query"  type="text" placeholder="Search Here ">
            <button type="submit" class="search-btn"><img class="search-image" src="mgf_search.svg" alt="search-pic"></button>
        </div>
        <br><b><h3 style="color:red">*** PLEASE ENTER SOME QUERY TO SEARCH ***</h3></br>
    </div>
</main>
<?php
}
?>
<div class="cpy" >
    <br> <br><b><h3  style="color:green">©prj_harsh_anurag</h3></br>
</div>
</body>
</html>