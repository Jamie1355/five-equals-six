function toggle_sidebar()
{
	sidebar_div = document.getElementById("sidebar");
	content_div = document.getElementById("content");
	if (sidebar_div.style.display == 'none')
	{
		sidebar_div.style.display = "block";
		content_div.style.width="800px";
	}else{
		sidebar_div.style.display = "none";
		content_div.style.width="1000px";
	}
	
}

function test()
{
	window.alert("Test function did get called");
}