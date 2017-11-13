function changeBackground() {
	var colours=
	["#6d7696","#59484f","#455c4f","#cc5543","#edb579","#dbe6af",
	"#6e352c","#cf5230","#f59a44","#e3c598","#8a6e64","#6e612f",
	"#b2e3e8","#694364","#b58bab","#e3d1e2","#402c69","#0f58ba"];
	document.body.style.background = colours[Math.floor(Math.random() * colours.length)];
}