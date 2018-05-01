var tds = document.getElementsByTagName("td"),
	x;
for (x = 0; x < tds.length; x++) {
	tds.item(x).addEventListener(
		"click",
		function() {
			if (this.firstChild.nodeValue != "Free")
				this.className = this.className == "selected" ? "" : "selected";
		}
	);
}
