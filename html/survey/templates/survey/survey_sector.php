<label for="industry_id">Sector <small class="required">(select 1)*</small></label>
<label id="industry_id-error" class="error" for="industry_id"></label>
<?php 
// only validation checking when it's not internal.
$suburl = $_SERVER['REQUEST_URI'];
$internal = false;
if (strpos($suburl, "form/internal/add")) {
  $internal = true;
}
?>
<fieldset>
  <div class="col-md-4" id="industry_id_col-1">
    <input type="radio" name="industry_id" class="industry_id" value="Agriculture" <?php if (!$internal){ echo "required";} ?>>&nbsp; Agriculture
    <br /><input type="radio" name="industry_id" class="industry_id" value="Arts, culture and tourism">&nbsp; Arts, culture and tourism
    <br /><input id="industry_id_cul" type="radio" name="industry_id" class="industry_id" value="Business, research and consulting">&nbsp; Business, research and consulting
    <br /><input type="radio" name="industry_id" class="industry_id" value="Consumer">&nbsp; Consumer
    <br /><input type="radio" name="industry_id" class="industry_id" value="Education">&nbsp; Education
    <br /><input type="radio" name="industry_id" class="industry_id" value="Energy and climate">&nbsp; Energy and climate
    <br /><input type="radio" name="industry_id" class="industry_id" value="Finance and insurance">&nbsp; Finance and insurance
  </div>
  <div class="col-md-4" id="industry_id_col-2">
    <input type="radio" name="industry_id" class="industry_id" value="Governance">&nbsp; Governance
    <br /><input type="radio" name="industry_id" class="industry_id" value="Health">&nbsp; Health
    <br /><input type="radio" name="industry_id" class="industry_id" value="Housing, construction &amp; real estate">&nbsp; Housing, construction &amp; real estate
    <br /><input type="radio" name="industry_id" class="industry_id" value="IT and geospatial">&nbsp; IT and geospatial
    <br /><input type="radio" name="industry_id" class="industry_id" value="Media and communications">&nbsp; Media and communications
    <br /><input type="radio" name="industry_id" class="industry_id" value="Transportation and logistics">&nbsp; Transportation and logistics
    <br /><input type="radio" name="industry_id" class="industry_id" id="industr_id_other" value="Other">&nbsp; Other
          <input type="text" class="form-control" style="display:none" id="industry_other" name="industry_other" placeholder="Describe other">
  </div>
</fieldset>