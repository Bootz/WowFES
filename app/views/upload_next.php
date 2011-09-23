<div id="next">
    <form id="upload" action="" method="post" class="cmxform">
        <input type="hidden" id="ingredientID" value="1">
        <input type="hidden" id="stepID" value="1">
        <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
        <fieldset>
            <legend>Upload</legend>
            <ol>
                <li><label for="name">料理名稱 <em>*</em></label> <input class="text-input" id="name" /><span class="error" id="name_error"></span></li>
                <li id="addIngredientField"><a href="#" onClick="addIngredientField(); return false;">新增材料</a> <em>*</em></li>
                <span id="ingredient"></span><span class="error" id="ingredient_error"></span>
                <li id="addStepField"><a href="#" onClick="addStepField(); return false;">新增料理步驟</a> <em>*</em></li>
                <span id="step"></span><span class="error" id="step_error"></span>
                <li><label for="tips">料理提示</label> <textarea id="tips" /></textarea></li>
                <li><label for="extra">補充資料</label> <textarea id="extra" /></textarea></li>
            </ol>
        </fieldset>
    </form>
    <input id="submit" type="submit" value="Upload" />
    <div id="clear"></div>
</div>
