<style type="text/css">
#upload{
	padding:15px;
    margin-top: 30px;
    margin-left:auto;
    margin-right:auto;
	font-weight:bold; font-size:1.3em;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	background:#f2f2f2;
	color:#3366cc;
	border:1px solid #ccc;
	width:150px;
	cursor:pointer !important;
	-moz-border-radius:5px; -webkit-border-radius:5px;
}
.darkbg{
	background:#ddd !important;
}
#status{
	font-family:Arial; padding:5px;
}
ul#files{ list-style:none; padding:0; margin:0; }
ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
ul#files li img{ max-width:180px; max-height:150px; }
.success{ background:#FFFFFF; border:1px solid #339933; }
.error{ background:#f0c6c3; border:1px solid #cc6622; }
</style>
<div id="form">
    <div id="upload" ><span>上傳食譜照片<span></div><span id="status" ></span>
    <ul id="files" ></ul>
</div>
<div id="clear"></div>
