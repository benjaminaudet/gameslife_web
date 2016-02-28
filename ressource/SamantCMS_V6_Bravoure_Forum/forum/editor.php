<script src="../js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<link rel="stylesheet" href="../forum/editor/minified/themes/default.min.css" type="text/css" media="all" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../forum/editor/minified/jquery.sceditor.bbcode.min.js"></script>

  
<script>
$(function() {
// Create the editor
$("textarea").sceditor({
	// Options go here
 
	// Option 1
	plugins: "bbcode",
 
	// Option 2
	toolbar: "bold,italic,underline|color,size,removeformat|left,right,center,justify|bulletlist,orderedlist|cut,copy,paste|youtube|link,unlink|image",
 
	// Option 3
	locale: "no-NB"
});
});
</script>