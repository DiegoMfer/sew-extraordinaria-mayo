<?php
// Define some data
$title = "Welcome to My Website";
$paragraphs = [
    "This is the first paragraph of my website.",
    "This is the second paragraph.",
    "And this is the third one."
];

// Start HTML output
echo "<!DOCTYPE html>\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>$title</title>\n";
echo "</head>\n";
echo "<body>\n";

// Output paragraphs
foreach ($paragraphs as $paragraph) {
    echo "<p>$paragraph</p>\n";
}

// End HTML output
echo "</body>\n";
echo "</html>";
?>
