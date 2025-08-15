<?php
$title = 'Edit Item';

$pageRights = 'create_item';
include('path.php');

include('includeFile.php');
$showCount = $_GET['showCount'];

if (empty($_GET['page']) && empty($showCount)) {
	$params = array(
		'page' => 1,
		'showCount' => 50
	);

	$baseUrl  = 'edit_item.php?' . http_build_query($params);
	echo '<script>window.location.href="' . $baseUrl . '"</script>';
}
?>
<style>
	#pagination li a {
		display: inline-block;
		text-decoration: none;
		padding: 5px 10px;
		color: #000;
		margin-left: 2px;
		border-radius: 5px;
	}

	#pagination li {
		display: inline
	}

	#pagination li a:hover:not(.active) {
		background-color: #ddd;
	}
</style>
</head>

<body class="nav-sm">
	<div class="container body">
		<div class="main_container">
			<?php
			include($path . 'side.php');
			include($path . 'mainBar.php');
			?>

			<div class="right_col" role="main">
				<div class="page-title">
					<div class="title_left">
						<h3><?php echo $title; ?></h3>
					</div>
				</div>
				<div class="clearfix"></div>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel" style="overflow-x:auto;">

							<div class="x_title">
								<h2><i class="fa fa-align-left"></i> Item List<small></small></h2>
								<div class="clearfix"></div>
							</div>

							<div class="x_content">
								<div class="box-content">
									<div class="col-md-3 responseStatus"></div>

									<div class="col-md-3" style="margin-bottom:10px; float:right;">
										<label style="margin: 0;">Search</label>
										<input type="text" placeholder="Search" class="form-control searchBox" />
									</div>
									<div class="col-md-2" style="margin-bottom:10px; float:right;">
										<label style="margin:0">Select Columns</label>
										<select name="colSelect" id="colSelect" class="colSelect form-control">
											<option value=""></option>
											<option value="saleTh">Sale Price</option>
											<option value="minPriceTh">Min Price</option>
											<option value="wlCashTh">WL Cash Price</option>
											<option value="wlCreditTh">WL Credit Price</option>
											<option value="discTh">Discount Price</option>
											<option value="preOrderTh">Pre Order</option>
											<option value="warrentyTh">Warrenty</option>
											<option value="barcodeTh">Barcode</option>
											<option value="sectionTh">Section</option>
											<option value="descTh">Description</option>
											<option value="level1Th">Level 1</option>
											<option value="level2Th">Level 2</option>
											<option value="level3Th">Level 3</option>
											<option value="level4Th">Level 4</option>
											<option value="level5Th">Level 5</option>
											<option value="invDisTh">invoice Discount</option>
											<option value="perPackTh">Per Pack/Bundle</option>
											<option value="supplierTh">Supplier Name</option> -->
											<option value="unit2Th">Unit 2 Price</option>

										</select>
									</div>
									<div class="col-md-2" style="margin-bottom:10px; float:right;">
										<label style="margin: 0;">Category</label>
										<select name="itemCat" class="itemCat form-control" id="itemCat">
											<option value="">VIEW ALL</option>
											<?php
											$sql_cetegory = $mysqli->query("SELECT * FROM `itemtable` GROUP BY CatID ORDER BY ID DESC");
											while ($row_cetegory = $sql_cetegory->fetch_array(MYSQLI_ASSOC)) {
												echo '<option value"' . $row_cetegory['CatID'] . '">' . $row_cetegory['CatID'] . '</option>';
											}
											?>
										</select>
									</div>

									<div class="col-md-2" style="margin-bottom:10px; float:right;">
										<label style="margin: 0;">Show Entries</label>
										<select name="showEntries" class="showEntries form-control" id="showEntries">
											<?php
											$entryArray = array(50, 100, 200, 500, 1000);
											foreach ($entryArray as $entryRec) {
												$optSel = $showCount == $entryRec ? 'selected' : '';
												echo '<option value="' . $entryRec . '" ' . $optSel . '>' . $entryRec . '</option>';
											}
											?>
										</select>
									</div>

									<div class="col-md-3" style="margin-bottom:10px; float:right;margin-top: 20px;">
										<button class="btn btn-dark addBranches"><i class="fa fa-plus"></i> Add Branches</button>
										<button class="btn btn-primary updateDatbleData">Update Records</button>
									</div>
								</div>

								<table id="myTables" class="table table-striped table-bordered table-hover invoSumryTB no-footer">
									<thead>
										<tr>
											<th>#</th>
											<th>Item No</th>
											<th style="width:25%;">Item name</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="itmNameSelector" name="itmNameSelector" id="itmNameSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="itmNmeClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Sales Price</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="saleprixeSelector" name="saleprixeSelector" id="saleprixeSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="slpriceClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Cost</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="costSelector" name="costSelector" id="costSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="cstClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="minPriceTh thShow">Min Price</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="minpriceSelector" name="minpriceSelector" id="minpriceSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="MnPrceClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Category</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="catrgorySelector" name="catrgorySelector" id="catrgorySelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="ctryClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Type</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="TypeSelector" name="TypeSelector" id="TypeSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="TypClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Extra Category</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="extractgrySelector" name="extractgrySelector" id="extractgrySelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="extrCtrClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Unit</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="UnitSelector" name="UnitSelector" id="UnitSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="UnitClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="wlCashTh thShow">WL Cash Price</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="WLCashPriceSelector" name="WLCashPriceSelector" id="WLCashPriceSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="WLCashPriceClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="wlCreditTh thShow">WL Credit Price</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="WLCreditPriceSelector" name="WLCreditPriceSelector" id="WLCreditPriceSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="WLCreditPriceClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="discTh thShow">Inv Discount</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="InvDiscountSelector" name="InvDiscountSelector" id="InvDiscountSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="InvDiscountClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th>Min Stock Level</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="MinStockLevelSelector" name="MinStockLevelSelector" id="MinStockLevelSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="MinStockLevelClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="preOrderTh thShow">Pre Order</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="PreOrderSelector" name="PreOrderSelector" id="PreOrderSelector">
													<option value="Amount">Amount</option>
													<option value="Percentage">Percentage</option>
													<option value="Change">Change</option>
												</select>
												<input class="PreOrderClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="warrentyTh thShow">Warranty</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="WarrantySelector" name="WarrantySelector" id="WarrantySelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="WarrantyClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="barcodeTh thShow">Barcode</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="barcodeSelector" name="barcodeSelector" id="barcodeSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="barcodeeClz" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="sectionTh thShow">Section</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="sectionSelector" name="sectionSelector" id="sectionSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="sectionn" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="descTh thShow">Description</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="descSelector" name="descSelector" id="descSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="desc" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="level1Th thShow">Level 1</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="level1Selector" name="level" id="level1">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="level1" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="level2Th thShow">Level 2</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="level2Selector" name="leve2" id="level2">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="level2" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="level3Th thShow">Level 3</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="level3Selector" name="leve2" id="level3">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="level3" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="level4Th thShow">Level 4</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="level4Selector" name="leve2" id="level4">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="level4" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="level5Th thShow">Level 5</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="level5Selector" name="leve2" id="level5">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="level5" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="invDisTh thShow">Inv Discount</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="invDisSelector" name="invDisSelector" id="invDisSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="invDis" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="perPackTh thShow">Per Pack Carton/Bundle</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="perPackSelector" name="perPackSelector" id="perPackSelector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="perPack" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
											<th style="display:none;" class="supplierTh thShow">Supplier Name</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="supplierSelector" name="supplierSelector" id="supplierSelector">
													<option value="Change">Change</option>
												</select>
												<select class="supplier" style="width:100%; height:35px; border:none;" type="select" value="">
													<option value=""></option>
													<?php
													$sql_supplier = $mysqli->query("SELECT ID, CompanyName  FROM vendor WHERE br_id = '$br_id'");
													while ($supplier = $sql_supplier->fetch_assoc()) {
														echo '<option value="' . $supplier['ID'] . '" data-companyname="' . $supplier['CompanyName'] . '">' . $supplier['CompanyName'] . '</option>';
													}
													?>
												</select>
											</th>
											<th style="display:none;" class="unit2Th thShow">Unit 2 Price</br>
												<select style="width:100%;margin-top: 5px;margin-bottom: 5px;" class="unit2Selector" name="unit2Selector" id="unit2Selector">
													<option value="Append">Append</option>
													<option value="Prepend">Prepend</option>
													<option value="Change">Change</option>
												</select>
												<input class="unit2" style="width:100%; height:35px; border:none;" type="text" value="" />
											</th>
										</tr>
									</thead>
									<tbody class="itmDet">

									</tbody>
								</table>
								<div id="pagination" style="float:right"></div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="modal" id="branchModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document" style="width:100%;">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Check the branches need to be edited</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<div class="col-sm-3">

								<label id="c_box" class="checkbox-inline rebate" style="font-size:11px">
									<input type="checkbox" name="br_all" id="br_all" class="br_all hiddnCls " value="br_all">
									All </label>
							</div>
							<?php

							$sql_branch = $mysqli->query(" SELECT `ID`,`name`  FROM `com_brnches` ORDER BY `com_brnches`.`name` ASC ");
							$br_count = '0';

							while ($branch = $sql_branch->fetch_array()) {
								$br_count = $sql_branch->num_rows;
								$_SESSION['br_coun'] = $br_count;
								$br_i++;

								$branch_id = $branch[0];
								$branch_name = $branch[1];


								if ($br_id == $branch_id) {
									//echo 'br coun '.$branch_id. ' i '.$br_id;
									echo '  <div class="col-md-3"> <label id="c_box" class="checkbox-inline rebate" style="font-size:11px;">
							<input type="checkbox" name="chk_br[]" id="chk_br" class="chk_br hiddnCls" value="' . $branch_id . '" checked />
							 ' . $branch_name . '  </label>  </div>';
								} else {
									echo '  <div class="col-md-3"> <label id="c_box" class="checkbox-inline rebate" style="font-size:11px;">
							<input type="checkbox" name="chk_br[]" id="chk_br" class="chk_br hiddnCls" value="' . $branch_id . '" />
							 ' . $branch_name . ' </label>  </div>';
								}

								//echo '<option value="'.$branch_id.'"   data-id="'.$branch_name.'"  > '.$branch_name.'</option>';

							}


							?>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Done</button>
					</div>
				</div>
			</div>
		</div>

		<?php include($path . 'footer.php') ?>

		<script>
			loadItems();

			$(document).on('change', '.itemCat', function(e) {
				e.preventDefault();
				loadUrlData();
			})

			function loadUrlData(){
				var params = new window.URLSearchParams(window.location.search);
				var showEntries  = $('.showEntries ').val();
				showEntries = showEntries==''? 50:showEntries;
				if ($("#itemCat option:selected").val() != '') {
					window.location.href = "edit_item.php?page=1&catID=" + encodeURIComponent($("#itemCat option:selected").val()) + "&showCount=" + showEntries + ""
				} else {
					window.location.href = "edit_item.php?page=1&showCount=" + showEntries + ""
				}
			}

			var catIDParam = '';
			var currentPageIDParam = '';
			var showCountDet = '';
			var currentAjax = null;

			function loadItems() {
				var searchWord = $('.searchBox').val();
				$('.responseStatus').html("Loading...");
				if (currentAjax != null) {
					currentAjax.abort();
				}

				var params = new window.URLSearchParams(window.location.search);
				if (params.get('catID') != null) {
					catIDParam = decodeURIComponent(params.get('catID'));
					$("#itemCat").val(catIDParam)
				}

				var pageValue = params.get('page');
				if (params.get('page') != null) {
					currentPageIDParam = decodeURIComponent(params.get('page'));
				}

				if (params.get('showCount') != null) {
					showCountDet = decodeURIComponent(params.get('showCount'));
				}

				currentAjax = $.ajax({
					url: 'ajx/itemAjx.php',
					type: 'post',
					dataType: 'json',
					data: {
						searchWord: searchWord,
						'btnLoadItems': 'LoadItems',
						urlParam: catIDParam,
						currentPageID: currentPageIDParam,
						'showRecords': showCountDet
					},
					success: function(data) {
						$('#myTables > tbody').html('')
						$('.responseStatus').html("");
						data.data.forEach(function(e) {

							$('#myTables > tbody').append(`
								<tr>
									<td style="width:180px;"></td>
									<td style="width:100px;">` + e.datas.itm_code + `</td>
									<td style="padding:0; width:250px;"><input  disabled editInput="` + $(this).find('td').eq(1).text() + `" class="editInput dis dis_` + e.datas.itm_code + ` editTxt itmName" itmtb="` + e.datas.itm_id + `" itmCode="` + e.datas.itm_code + `" style="width:100%; height:35px; border:none;" key="0" type="text" value="` + e.datas.Description + `" /></td>
									<td style="padding:0; width:250px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt saleprice" style="width:100%; height:35px; border:none;" key="1" type="text" value="` + e.datas.sale_pr + `" /></td>
									<td style="padding:0; width:250px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt costprice" style="width:100%; height:35px; border:none;" key="2" type="text" value="` + e.datas.cost_pr + `" /></td>
									<td style="display:none; padding:0; width:250px;" class="minPriceTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt minsale" style="width:100%; height:35px; border:none;" key="3" type="text" value="` + e.datas.MinSale + `" /></td>
									<td style="padding:0; width:200px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt catID" style="width:100%; height:35px; border:none;" key="4" type="text" value="` + e.datas.CatID + `" /></td>
									<td style="padding:0; width:190px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt typeField" style="width:100%; height:35px; border:none;" key="5" type="text" value="` + e.datas.Type + `" /></td>
									<td style="padding:0; width:190px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.XWord + `" /></td>
									<td style="padding:0; width:200px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.Unit + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="wlCashTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.wl_cash_price + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="wlCreditTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.wl_credit_price + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="discTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.ItemDisc + `" /></td>
									<td style="padding:0; width:200px;"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.reorder2 + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="preOrderTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.POrder + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="warrentyTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt xWord" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.warranty + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="barcodeTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt barcode" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.barcode + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="sectionTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt Section" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.Section + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="descTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.Taxt + `" /></td>
									
									<td style="display:none; padding:0; width:200px;" class="level1Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.priLV1 + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="level2Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.priLV2 + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="level3Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.priLV3 + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="level4Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.priLV4 + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="level5Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.priLV5 + `" /></td>

									<td style="display:none; padding:0; width:200px;" class="invDisTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.ItemDisc + `" /></td>
									<td style="display:none; padding:0; width:200px;" class="perPackTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.PerPack + `" /></td>

									<td style="display:none; padding:0; width:200px;" class="supplierTh"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;display:none;" key="6" type="text" value="` + e.ven.ID + `" /><div id="display-name" style="font-size: 12px; margin-top: 10px;margin-left: 8px;">` + e.ven.CompanyName + `</div></td>
									<td style="display:none; padding:0; width:200px;" class="unit2Th"><input  disabled class="dis dis_` + e.datas.itm_code + ` editTxt" style="width:100%; height:35px; border:none;" key="6" type="text" value="` + e.datas.Unit2 + `" /></td>

									
								</tr>
							`)

							$('.responseStatus').html("");
							// table row coount updating acording to the pagination
							var values = '';
							var startRecord = ((pageValue - 1) * e.maxRecords);
							var endRecord = startRecord + e.maxRecords;

							for (var i = startRecord; i <= endRecord; i++) {
								var value = i;
								values += value + ', ';
							}

							values = values.slice(0, -2).split(',');

							$('table tr').each(function(index) {
								$(this).find('td').eq(0).text(values[index]);
							});
							$('table tr').each(function(index) {
								$(this).find('td').eq(0).append(`<button type="button" style="float:right;" class="btn btn-primary btn-sm edit" edit="` + $(this).find('td').eq(1).text() + `"><i class="fa fa-edit"></i></button>`);
							});

							// pagination
							var paginationLinks = "";
							var maxPages = 5;
							var startPage = Math.max(1, pageValue - Math.floor(maxPages / 2));
							var endPage = Math.min(e.count, startPage + maxPages - 1);

							var params = new window.URLSearchParams(window.location.search);

							if (endPage - startPage < maxPages - 1) {
								startPage = Math.max(1, endPage - maxPages + 1);
							} else {
								var ellipsis = '<span class="pagination-dots">...</span> ';
								if (startPage > 1) {
									paginationLinks += '<li><a href="edit_item.php?page=1&showCount=' + params.get('showCount') + '" class="pagination-link" data-page="1">1</a></li>';
									paginationLinks += ellipsis;
								}
								for (var j = startPage; j <= endPage; j++) {
									if (pageValue == j) {
										paginationLinks += '<span style="background-color: #4caf50;color: #fff;text-decoration: none;padding: 5px 10px;border-radius: 5px;">' + j + '</span>';
									} else {
										paginationLinks += '<li><a href="edit_item.php?page=' + j + '&showCount=' + params.get('showCount') + '" class="pagination-link" data-page="' + j + '">' + j + '</a> </li>';
									}
								}
								// if (endPage < e.count) {
								// 	paginationLinks += ellipsis;
								// 	paginationLinks += '<a href="#" class="pagination-link" data-page="' + e.count + '">' + e.count + '</a> ';
								// }
							}

							// Display the last 3 pages at the end of the pagination links
							if (e.count > maxPages) {
								var lastStartPage = e.count - (maxPages - 2);
								var lastEndPage = e.count;
								paginationLinks += '<span class="pagination-dots">...</span> ';
								for (var s = lastStartPage; s <= lastEndPage; s++) {
									if (pageValue == s) {
										paginationLinks += '<span style="background-color: #4caf50;color: #fff;text-decoration: none;padding: 5px 10px;border-radius: 5px;">' + s + '</span>';
									} else {
										paginationLinks += '<li><a href="edit_item.php?page=' + s + '&showCount=' + params.get('showCount') + '" class="pagination-link" data-page="' + s + '">' + s + '</a> </li>';
									}
								}
							}

							$("#pagination").html(paginationLinks);

						})

						showColumns();
					}
				})
			}

			var lastTyped = '';
			$(document).on('focus', '.editTxt', function() {
				this.select();
				lastTyped = $(this).val();
			})

			$(document).on('focusout', '.searchBox', function(e) {
				loadItems();
			});

			$(document).on('focusout', '.editTxt', function(e) {
				e.preventDefault();
				if (e.which === 13) {
					var attrkey = $(this).attr('key');
					attrkey = parseFloat(attrkey - 1)
					$(this).closest('tr').next().find('input[type=text]:eq(' + attrkey + ')').focus();
				}

				if (e.which == 40 || e.which == 98) {
					var attrkey = $(this).attr('key');
					attrkey = parseFloat(attrkey)
					$(this).closest('tr').next().find('input[type=text]:eq(' + attrkey + ')').focus();
				}

				if (e.which == 38 || e.which == 104) {
					var attrkey = $(this).attr('key');
					attrkey = parseFloat(attrkey);
					$(this).closest('tr').prev().find('input[type=text]:eq(' + attrkey + ')').focus();
				}
			})

			$(document).on('focusout', '.itmNmeClz', function() {
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.itmNameSelector').val() == 'Append') {

						$(this).find("td input").eq(0).val($(this).find("td input").eq(0).val() + thisText)

					}
					if ($('.itmNameSelector').val() == 'Prepend') {

						$(this).find("td input").eq(0).val(thisText + $(this).find("td input").eq(0).val())

					}
					if ($('.itmNameSelector').val() == 'Change') {

						$(this).find("td input").eq(0).val(thisText)

					}
				});
			});

			$(document).on('focusout', '.slpriceClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(1).val();

					if ($('.saleprixeSelector').val() == 'Amount') {

						$(this).find("td input").eq(1).val(calculateAmount(newValue, initialValue))

					} else if ($('.saleprixeSelector').val() == 'Percentage') {

						$(this).find("td input").eq(1).val(calculatePercentage(newValue, initialValue))

					} else if ($('.saleprixeSelector').val() == 'Change') {

						$(this).find("td input").eq(1).val(newValue)

					}
				});
			});

			$(document).on('focusout', '.cstClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(2).val();

					if ($('.costSelector').val() == 'Amount') {

						$(this).find("td input").eq(2).val(calculateAmount(newValue, initialValue))

					} else if ($('.costSelector').val() == 'Percentage') {

						$(this).find("td input").eq(2).val(calculatePercentage(newValue, initialValue))

					} else if ($('.costSelector').val() == 'Change') {

						$(this).find("td input").eq(2).val(newValue)

					}
				});
			});

			$(document).on('focusout', '.MnPrceClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(3).val();

					if ($('.minpriceSelector').val() == 'Amount') {

						$(this).find("td input").eq(3).val(calculateAmount(newValue, initialValue))

					} else if ($('.minpriceSelector').val() == 'Percentage') {

						$(this).find("td input").eq(3).val(calculatePercentage(newValue, initialValue))

					} else if ($('.minpriceSelector').val() == 'Change') {

						$(this).find("td input").eq(3).val(newValue)

					}
				});
			});

			$(document).on('focusout', '.ctryClz', function() {
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					var cellValue = $(this).find("td input").eq(4).val();

					if ($('.catrgorySelector').val() == 'Append') {

						$(this).find("td input").eq(4).val(cellValue + thisText)

					}
					if ($('.catrgorySelector').val() == 'Prepend') {

						$(this).find("td input").eq(4).val(thisText + cellValue)

					}
					if ($('.catrgorySelector').val() == 'Change') {

						$(this).find("td input").eq(4).val(thisText)

					}
				});
			});

			$(document).on('focusout', '.TypClz', function() {
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					var cellValue = $(this).find("td input").eq(5).val();

					if ($('.TypeSelector').val() == 'Append') {

						$(this).find("td input").eq(5).val(cellValue + thisText)

					}
					if ($('.TypeSelector').val() == 'Prepend') {

						$(this).find("td input").eq(5).val(thisText + cellValue)

					}
					if ($('.TypeSelector').val() == 'Change') {

						$(this).find("td input").eq(5).val(thisText)

					}
				});
			});

			$(document).on('focusout', '.extrCtrClz', function() {
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					var cellValue = $(this).find("td input").eq(6).val();

					if ($('.extractgrySelector').val() == 'Append') {

						$(this).find("td input").eq(6).val(cellValue + thisText)

					}
					if ($('.extractgrySelector').val() == 'Prepend') {

						$(this).find("td input").eq(6).val(thisText + cellValue)

					}
					if ($('.extractgrySelector').val() == 'Change') {

						$(this).find("td input").eq(6).val(thisText)

					}
				});
			});

			$(document).on('focusout', '.UnitClz', function(e) {
				e.preventDefault()
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.UnitSelector').val() == 'Append') {

						$(this).find("td input").eq(7).val($(this).find("td input").eq(7).val() + thisText)

					}
					if ($('.UnitSelector').val() == 'Prepend') {

						$(this).find("td input").eq(7).val(thisText + $(this).find("td input").eq(7).val())

					}
					if ($('.UnitSelector').val() == 'Change') {

						$(this).find("td input").eq(7).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.WLCashPriceClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(8).val();

					if ($('.WLCashPriceSelector').val() == 'Amount') {

						$(this).find("td input").eq(8).val(calculateAmount(newValue, initialValue))

					} else if ($('.WLCashPriceSelector').val() == 'Percentage') {

						$(this).find("td input").eq(8).val(calculatePercentage(newValue, initialValue))

					} else if ($('.WLCashPriceSelector').val() == 'Change') {

						$(this).find("td input").eq(8).val(newValue)

					}
				});
			})

			$(document).on('focusout', '.WLCreditPriceClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(9).val();

					if ($('.WLCreditPriceSelector').val() == 'Amount') {

						$(this).find("td input").eq(9).val(calculateAmount(newValue, initialValue))

					} else if ($('.WLCreditPriceSelector').val() == 'Percentage') {

						$(this).find("td input").eq(9).val(calculatePercentage(newValue, initialValue))

					} else if ($('.WLCreditPriceSelector').val() == 'Change') {

						$(this).find("td input").eq(9).val(newValue)

					}
				});
			})

			$(document).on('focusout', '.InvDiscountClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(10).val();

					if ($('.InvDiscountSelector').val() == 'Amount') {

						$(this).find("td input").eq(10).val(calculateAmount(newValue, initialValue))

					} else if ($('.InvDiscountSelector').val() == 'Percentage') {

						$(this).find("td input").eq(10).val(calculatePercentage(newValue, initialValue))

					} else if ($('.InvDiscountSelector').val() == 'Change') {

						$(this).find("td input").eq(10).val(newValue)

					}
				});
			})

			$(document).on('focusout', '.MinStockLevelClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(11).val();

					if ($('.MinStockLevelSelector').val() == 'Amount') {

						$(this).find("td input").eq(11).val(calculateAmount(newValue, initialValue))

					} else if ($('.MinStockLevelSelector').val() == 'Percentage') {

						$(this).find("td input").eq(11).val(calculatePercentage(newValue, initialValue))

					} else if ($('.MinStockLevelSelector').val() == 'Change') {

						$(this).find("td input").eq(11).val(newValue)

					}
				});
			})

			$(document).on('focusout', '.PreOrderClz', function() {
				var newValue = $(this).val();
				$("#myTables tbody tr").each(function() {
					var initialValue = $(this).find("td input").eq(12).val();

					if ($('.PreOrderSelector').val() == 'Amount') {

						$(this).find("td input").eq(12).val(calculateAmount(newValue, initialValue))

					} else if ($('.PreOrderSelector').val() == 'Percentage') {

						$(this).find("td input").eq(12).val(calculatePercentage(newValue, initialValue))

					} else if ($('.PreOrderSelector').val() == 'Change') {

						$(this).find("td input").eq(12).val(newValue)

					}
				});
			})

			$(document).on('keyup', '.WarrantyClz', function(e) {
				e.preventDefault();
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.WarrantySelector').val() == 'Append') {

						$(this).find("td input").eq(13).val($(this).find("td input").eq(13).val() + thisText)

					}
					if ($('.WarrantySelector').val() == 'Prepend') {

						$(this).find("td input").eq(13).val(thisText + $(this).find("td input").eq(13).val())

					}
					if ($('.WarrantySelector').val() == 'Change') {

						$(this).find("td input").eq(13).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.barcodeeClz', function(e) {
				e.preventDefault();
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.barcodeSelector').val() == 'Append') {

						$(this).find("td input").eq(14).val($(this).find("td input").eq(14).val() + thisText)

					}
					if ($('.barcodeSelector').val() == 'Prepend') {

						$(this).find("td input").eq(14).val(thisText + $(this).find("td input").eq(14).val())

					}
					if ($('.barcodeSelector').val() == 'Change') {

						$(this).find("td input").eq(14).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.sectionn', function(e) {
				e.preventDefault();
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.sectionSelector').val() == 'Append') {

						$(this).find("td input").eq(15).val($(this).find("td input").eq(15).val() + thisText)

					}
					if ($('.sectionSelector').val() == 'Prepend') {

						$(this).find("td input").eq(15).val(thisText + $(this).find("td input").eq(15).val())

					}
					if ($('.sectionSelector').val() == 'Change') {

						$(this).find("td input").eq(15).val(thisText)

					}
				});
			})
			$(document).on('focusout', '.desc', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.descSelector').val() == 'Append') {

						$(this).find("td input").eq(16).val($(this).find("td input").eq(16).val() + thisText)

					}
					if ($('.descSelector').val() == 'Prepend') {

						$(this).find("td input").eq(16).val(thisText + $(this).find("td input").eq(16).val())

					}
					if ($('.descSelector').val() == 'Change') {

						$(this).find("td input").eq(16).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.level1', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.level1Selector').val() == 'Append') {

						$(this).find("td input").eq(17).val($(this).find("td input").eq(17).val() + thisText)

					}
					if ($('.level1Selector').val() == 'Prepend') {

						$(this).find("td input").eq(17).val(thisText + $(this).find("td input").eq(17).val())

					}
					if ($('.level1Selector').val() == 'Change') {

						$(this).find("td input").eq(17).val(thisText)

					}
				});
			})
			$(document).on('focusout', '.level2', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.level2Selector').val() == 'Append') {

						$(this).find("td input").eq(18).val($(this).find("td input").eq(18).val() + thisText)

					}
					if ($('.level2Selector').val() == 'Prepend') {

						$(this).find("td input").eq(18).val(thisText + $(this).find("td input").eq(18).val())

					}
					if ($('.level2Selector').val() == 'Change') {

						$(this).find("td input").eq(18).val(thisText)

					}
				});
			})
			$(document).on('focusout', '.level3', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.level3Selector').val() == 'Append') {

						$(this).find("td input").eq(19).val($(this).find("td input").eq(19).val() + thisText)

					}
					if ($('.level3Selector').val() == 'Prepend') {

						$(this).find("td input").eq(19).val(thisText + $(this).find("td input").eq(19).val())

					}
					if ($('.level3Selector').val() == 'Change') {

						$(this).find("td input").eq(19).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.level4', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.level4Selector').val() == 'Append') {

						$(this).find("td input").eq(20).val($(this).find("td input").eq(20).val() + thisText)

					}
					if ($('.level4Selector').val() == 'Prepend') {

						$(this).find("td input").eq(20).val(thisText + $(this).find("td input").eq(20).val())

					}
					if ($('.level4Selector').val() == 'Change') {

						$(this).find("td input").eq(20).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.level5', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.level5Selector').val() == 'Append') {

						$(this).find("td input").eq(21).val($(this).find("td input").eq(21).val() + thisText)

					}
					if ($('.level5Selector').val() == 'Prepend') {

						$(this).find("td input").eq(21).val(thisText + $(this).find("td input").eq(21).val())

					}
					if ($('.level5Selector').val() == 'Change') {

						$(this).find("td input").eq(21).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.invDis', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.invDisSelector').val() == 'Append') {

						$(this).find("td input").eq(22).val($(this).find("td input").eq(22).val() + thisText)

					}
					if ($('.invDisSelector').val() == 'Prepend') {

						$(this).find("td input").eq(22).val(thisText + $(this).find("td input").eq(22).val())

					}
					if ($('.invDisSelector').val() == 'Change') {

						$(this).find("td input").eq(22).val(thisText)

					}
				});
			})
			$(document).on('focusout', '.perPack', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.perPackSelector').val() == 'Append') {

						$(this).find("td input").eq(23).val($(this).find("td input").eq(23).val() + thisText)

					}
					if ($('.perPackSelector').val() == 'Prepend') {

						$(this).find("td input").eq(23).val(thisText + $(this).find("td input").eq(23).val())

					}
					if ($('.perPackSelector').val() == 'Change') {

						$(this).find("td input").eq(23).val(thisText)

					}
				});
			})

			$(document).on('focusout', '.supplier', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				var selectedOption = $(this).find('option:selected');
				var companyName = selectedOption.data('companyname');

				$("#myTables tbody tr").each(function() {

					if ($('.supplierSelector').val() == 'Change') {

						var inputField = $(this).find("td input").eq(24);
						inputField.val(thisText);
						inputField.hide();
						$(this).find("td #display-name").text(companyName);
					}
				});
			})

			$(document).on('focusout', '.unit2', function(e) {
				e.preventDefault();
				thisText
				var thisText = $(this).val();
				$("#myTables tbody tr").each(function() {
					if ($('.unit2Selector').val() == 'Append') {

						$(this).find("td input").eq(25).val($(this).find("td input").eq(25).val() + thisText)

					}
					if ($('.unit2Selector').val() == 'Prepend') {

						$(this).find("td input").eq(25).val(thisText + $(this).find("td input").eq(25).val())

					}
					if ($('.unit2Selector').val() == 'Change') {

						$(this).find("td input").eq(25).val(thisText)

					}
				});
			})

			function calculateAmount(e, i) {
				e = e == '' ? 0 : parseFloat(e);
				i = i == '' ? 0 : parseFloat(i);
				var calculates = i + e;
				return calculates
			}

			function calculatePercentage(e, i) {
				e = e == '' ? 0 : parseFloat(e);
				i = i == '' ? 0 : parseFloat(i);
				var calPercent = i + (i * (e / 100));
				return calPercent;
			}

			$(document).on('click', '.updateDatbleData', function(e) {
				e.preventDefault();



				var data = [];
				$("#myTables tbody tr").each(function(index) {
					var codeInput = $(this).find("td input").eq(0);
					if (codeInput.is(":enabled")) {
						var code = codeInput.attr("itmCode");
						var id = codeInput.attr("itmtb");
						var itmName = codeInput.val();
						var salepriceInput = $(this).find("td input").eq(1);
						var costpriceInput = $(this).find("td input").eq(2);
						var minsaleInput = $(this).find("td input").eq(3);
						var catIDInput = $(this).find("td input").eq(4);
						var typeFieldInput = $(this).find("td input").eq(5);
						var xWordInput = $(this).find("td input").eq(6);
						var UnitInput = $(this).find("td input").eq(7);
						var WLCashPriceInput = $(this).find("td input").eq(8);
						var WLCreditPriceInput = $(this).find("td input").eq(9);
						var InvDiscountInput = $(this).find("td input").eq(10);
						var MinStockLevelInput = $(this).find("td input").eq(11);
						var PreOrderInput = $(this).find("td input").eq(12);
						var WarrantyInput = $(this).find("td input").eq(13);
						var level1Input = $(this).find("td input").eq(17);
						var level2Input = $(this).find("td input").eq(18);
						var level3Input = $(this).find("td input").eq(19);
						var level4Input = $(this).find("td input").eq(20);
						var level5Input = $(this).find("td input").eq(21);
						var invDisInput = $(this).find("td input").eq(22);
						var perPackInput = $(this).find("td input").eq(23);
						var supplierInput = $(this).find("td input").eq(24);
						var barcodeInput = $(this).find("td input").eq(14);
						var sectionInput = $(this).find("td input").eq(15);
						var descInput = $(this).find("td input").eq(16);
						var unit2 = $(this).find("td input").eq(25);

						var checkboxValues = []; // Initialize an array to store checkbox values
						$('.chk_br:checked').each(function() {
							checkboxValues.push($(this).val()); // Add the checked checkbox values to the array
						});

						data.push({
							value: itmName,
							value2: salepriceInput.val(),
							value3: costpriceInput.val(),
							value4: minsaleInput.val(),
							value5: catIDInput.val(),
							value6: typeFieldInput.val(),
							value7: xWordInput.val(),
							value16: barcodeInput.val(),
							value18: sectionInput.val(),
							value8: id,
							value17: code,
							value9: UnitInput.val(),
							value10: WLCashPriceInput.val(),
							value11: WLCreditPriceInput.val(),
							value12: InvDiscountInput.val(),
							value13: MinStockLevelInput.val(),
							value14: PreOrderInput.val(),
							value15: WarrantyInput.val(),
							value19: descInput.val(),
							checkboxValues: checkboxValues,
							level1: level1Input.val(),
							level2: level2Input.val(),
							level3: level3Input.val(),
							level4: level4Input.val(),
							level5: level5Input.val(),
							invDis: invDisInput.val(),
							perPack: perPackInput.val(),
							supplier: supplierInput.val(),
							unit2: unit2.val()
						});
					}
				});

				$.ajax({
					url: 'ajx/itemAjx.php',
					type: 'POST',
					dataType: 'json',
					data: {
						data: data,
						'btnupdateBtn': 'updateItm'
					},
					success: function(response) {
						if (response.status == 200) {
							$('.updateDatbleData').text('Updating Records...');
							$('.updateDatbleData').css('opacity', '0.4');
							$('.updateDatbleData').css('pointer-events', 'none');
							Swal.fire({
								icon: 'success',
								title: 'Congratulations',
								text: response.message
							}).then((result) => {
								if (result.isConfirmed) {
									location.reload();
								}
							})
						} else {
							$('.updateDatbleData').text('Update Records');
							$('.updateDatbleData').css('opacity', '1');
							$('.updateDatbleData').css('pointer-events', 'all');
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: "No Records to Update."
							})
						}
					}
				});
			})



			$(document).on('change', '.showEntries', function(e) {
				e.preventDefault();
				loadUrlData();
			})

			$(document).on('change', '.colSelect', function() {
				var thisVal = $(this).val();
				$('.' + thisVal).show();


				// Remove the selected option from the select box
				$(this).find('option[value="' + thisVal + '"]').attr('showFiel', "YES");
				//	showColumns();
			});

			function showColumns() {
				$('.colSelect').find('option').each(function(index, element) {
					// alert($(element).attr('showFiel'));
					if ($(element).attr('showFiel') == 'YES') {
						$('.' + $(element).val()).show();
					}
				});
			}

			$(document).on('click', '.addBranches', function() {
				$('#branchModal').modal('show')

			});

			$(document).on('change', '#br_all', function() {


				if ($(this).is(':checked')) {
					$('input[id=chk_br]:checkbox').prop("checked", $(this).is(':checked'));
					// $(this).attr('checked', 'checked');
					//alert ('br all');
					//$(".chk_br").attr('checked', 'checked');  // checked
				} else {
					$(".chk_br").removeAttr("checked");
				}


			});
			$(document).on('click', '.edit', function() {
				var thisVal = $(this).attr('edit')
				$('.dis_' + thisVal).prop('disabled', false);

			});

			$(document).on('click', '.edit', function() {
				var thisVal = $(this).attr('edit');
				var $button = $(this);

				if ($button.hasClass('btn-light')) {
					$button.removeClass('btn-light').addClass('btn-primary');
					$('.dis_' + thisVal).prop('disabled', true);
					$button.html('<i class="fa fa-edit"></i>');
				} else {
					$button.removeClass('btn-primary').addClass('btn-light');
					$('.dis_' + thisVal).prop('disabled', false);
					$button.html('<i class="fa fa-close" style="color:red;"></i>');
				}
			});

			// $(document).on('click', '.editInput', function() {
			// 	var thisVal = $(this).attr('editInput');
			// 	var $button = $(this);
			// 	alert(thisVal)

			// 	if ($button.hasClass('btn-light')) {
			// 		$('.dis_' + thisVal).prop('disabled', true);
			// 	} else {
			// 		$('.dis_' + thisVal).prop('disabled', false);
			// 	}
			// });
		</script>