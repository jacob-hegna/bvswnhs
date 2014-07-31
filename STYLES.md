# Styles
**camelCase** should always be used

functions (and boolean blocks) should be formatted as

```
function testFunction() {
	if(1 + 1 == 2) {
			} else {
			}
	while(1 == 1) {
			}}
```

four **spaces**, not tabs

# File structure
Javascript that will always run should go in `js/main.js`, all ajax-called php should go in `php/main.php`, and all pages loaded via ajax should go in `php/pages/`.