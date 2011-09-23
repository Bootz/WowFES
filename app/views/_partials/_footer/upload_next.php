<script type="text/javascript" src="/js/vendor/jquery.highlightFade.js"></script>
<script type="text/javascript">
function addIngredientField() {
    var id = document.getElementById("ingredientID").value;
    $("#ingredient").append("<li id='row" + id + "'><label for='ingredient" + id + "'>材料</label> <input name='ingredient[]' id='iName" + id + "' size='15'> 數量:<input name='quality[]' id='iQual" + id + "' size='3' value='1'> <select id='select'><option value='個'>個</option><option value='克'>克</option><option value='斤'>斤</option><option value='碗'>碗</option></select><a href='#' onClick='removeField(\"#row" + id + "\"); return false;'>移除</a></li>");

    hightlightFace('#row' + id);

    id = (id - 1) + 2;
    document.getElementById("ingredientID").value = id;
}

function addStepField() {
    var id = document.getElementById("stepID").value;
    $("#step").append("<li id='row" + id + "'><label for='step" + id + "'>料理步驟</label> <textarea name='step[]' id='step" + id + "' size='15'></textarea> <a href='#' onClick='removeField(\"#row" + id + "\"); return false;'>移除</a></li>");

    hightlightFace('#row' + id);

    id = (id - 1) + 2;
    document.getElementById("stepID").value = id;
}

function hightlightFace(id) {
    $(id).highlightFade({
        speed:1000
    });
}

function removeField(id) {
    $(id).remove();
}
</script>
<script type="text/javascript">
	$(function() {
		$('.error').hide();
		$('input.text-input').css({backgroundColor:"#FFFFFF"});
		$('input.text-input').focus(function(){
			$(this).css({backgroundColor:"#EEEEAA"});
		});
		$('input.text-input').blur(function(){
			$(this).css({backgroundColor:"#FFFFFF"});
		});

		$("#submit").click(function() {
			$('.error').hide();

			var error_empty_field = "This field is required.";

			var name = $("input#name").val();
			if (name == "") {
				$("#name_error").show();
				$("#name_error").html(error_empty_field);
				$("input#name").focus();
				return false;
			}

                        var ingredient = "";
                        var ingredientID = document.getElementById("ingredientID").value;
                        for (i = 1; i < ingredientID; i++) {
                            var getIngredientID = document.getElementById("iName" + i);
                            if (getIngredientID != null && getIngredientID.value != "") {
                                var getQualityID = document.getElementById("iQual" + i);
                                if (getQualityID != null && getQualityID.value != "") {
                                    var unit = $("#select option:selected").text();
                                    var ingredient = ingredient + getIngredientID.value + ":" + getQualityID.value + ":" + unit + ";";
                                    //alert(getIngredientID.value + " " + getQualityID.value + " " + unit);
                                }
                            }
                        }
			if (ingredient == "") {
				$("#ingredient_error").show();
				$("#ingredient_error").html(error_empty_field);
				return false;
			}
			//alert(ingredient);

                        var step = "";
                        var stepID = document.getElementById("stepID").value;
                        for (i = 1; i < stepID; i++) {
                            var getStepID = document.getElementById("step" + i);
                            if (getStepID != null && getStepID.value != "") {
			        var step = step + getStepID.value + ";";
			        //alert(getIngredientID.value + " " + getQualityID.value + " " + unit);
                            }
                        }
			//alert(step);
			if (step == "") {
				$("#step_error").show();
				$("#step_error").html(error_empty_field);
				return false;
			}

                        var tips = document.getElementById("tips").value;
                        var extra = document.getElementById("extra").value;
			//alert(tips);
			//alert(extra);

			var datas = 'name=' + name + '&ingredient=' + ingredient + '&step=' + step + '&tips=' + tips + '&extra=' + extra;
			$.ajax({
				type: "POST",
				url:  "/upload_next/add",
				data: datas,
				success: function(data) {
					$("#next").html(data);
				}
			});
			return false;
		});
	});
</script>
