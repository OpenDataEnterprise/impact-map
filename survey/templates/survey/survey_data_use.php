<label for="data_use_type[]">What are the <u>most relevant</u> types of data your organization uses? 
    <small class="required">(select all that apply)*</small>
</label>
<label id="data_use_type[]-error" class="error" for="data_use_type[]"></label>
<?php 
// only validation checking when it's not internal.
$suburl = $_SERVER['REQUEST_URI'];
$internal = false;
if (strpos($suburl, "form/internal/add")) {
  $internal = true;
}
?>
<div class="col-md-4" id="data_type_col-1">
    <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Agriculture" <?php if (!$internal){ echo "required";} ?>>&nbsp; <span>Agriculture</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Arts and culture">&nbsp; <span>Arts and culture</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Business">&nbsp; <span>Business</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Consumer">&nbsp; <span>Consumer</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Demographic and social">&nbsp; <span>Demographic and social</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Economics">&nbsp; <span>Economics</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Education">&nbsp; <span>Education</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Energy">&nbsp; <span>Energy</span>
</div>
<div class="col-md-4" id="data_type_col-2">
    <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Environment">&nbsp; <span>Environment</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Finance">&nbsp; <span>Finance</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Geospatial">&nbsp; <span>Geospatial</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Government operations">&nbsp; <span>Government operations</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Health/healthcare">&nbsp; <span>Health/healthcare</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Housing">&nbsp; <span>Housing</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="International development">&nbsp; <span>International development</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Legal">&nbsp; <span>Legal</span>
</div>
<div class="col-md-4" id="data_type_col-3">
    <!-- <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Manufacturing">&nbsp; <span>Manufacturing</span> -->
    <input type="checkbox" name="data_use_type[]" class="data_use_type" value="Science and research">&nbsp; <span>Science and research</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Public safety">&nbsp; <span>Public safety</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Tourism">&nbsp; <span>Tourism</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Transportation">&nbsp; <span>Transportation</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" value="Weather">&nbsp; <span>Weather</span>
    <br /><input type="checkbox" name="data_use_type[]" class="data_use_type" id="data_use_type_checkbox_other" value="Other">&nbsp; <span>Other</span>
          <input type="text" class="form-control" style="display:none" id="data_use_type_other" name="data_use_type_other" placeholder="Provide details">
</div>