<?php

			use Expertix\Core\Util\Log;

function showPage($theme, $pageData){
			//$serviceId = $data->get("serviceId");
			$theme->setAutoPrint(true);

			$theme->title("Онлайн-регистрация", 3, "");
			$user = $pageData->getUser();
			$dataObject = $pageData->getDataObject();

			if (!$user) {
			} else {
				$subscribed = true;
				$userServices = $user->get("services");
				$productServices = $dataObject->get("services");
				
				//				Log::d("User", $user);
				//				Log::d("User Services $serviceId", $userServices);
				//				Log::d("Product Services $serviceId", $data->get("services"));
				if ($userServices) {
					foreach ($userServices as $key => $service) {
						$userServiceId = $service["serviceId"];
						foreach ($productServices as $key => $productService) {
							$productServiceId = $productService["serviceId"];
					//						Log::debug("Service: $id, product service: $serviceId");
							if ($userServiceId == $productServiceId) {
								$productServices[$productServiceId]["subscribed"] = true;
							}
							
						}
					}
				}
			}

	if (!$user) {
		$theme->moduleComponent("store", "product/form-signup-course", [$user]);
	}	
//	$theme->moduleComponent("store", "product/product-services", [$$productServices]);

//			if ($subscribed) {
//				$theme->moduleComponent("store", "product/form-already-subscribed", []);
//			} else {
//				$theme->moduleComponent("store", "product/form-subscribe", [$serviceId]);
//			}

}


?>
<div class="mt-5">
	<?= $theme->sectionTitle("Записаться на курс", "", "bg-danger text-white shadow", "#") ?>
</div>
<div class="row mt-5">
	<div class="col-12 col-md-8">
		<div class="mr-0 mr-md-5">
			<?php
//Log::d("", $pageData->get("services"));
				showPage($theme, $pageData);

			?>

			<!--div><a href="https://forms.gle/9EGUQJx7g9qSeBpB9" target="top" class="title3 text-success">Отправить заявку на курс</a></div-->
			<!--div class="row my-3">
			<div class="col-12 col-md-4 my-3">
				<input id="qsw" type="button" value="Отправить заявку" class="form-control form-control-lg btn-success btn-lg" />
			</div>
			<div class="col-12 col-md-8">
			</div>

		</div-->

		</div>
	</div>
	<div class="col-12 col-md-4 border-left mt-5 mt-md-0">
		<div class="ml-0 ml-md-5 ">
			<div class="title4">Менеджер курса:</div>
			<div class="">Драчева Светлана Ильинична</div>
			<div class="title4">Телефон:</div>
			<div class="">+7 (913) 999-54-75</div>
		</div>
	</div>
</div>