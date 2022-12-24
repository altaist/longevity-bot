	<?php $view->component("header", ["title" => "Longevity Profile",  "home_href" => "'home'", "class" => "bg-deep-orange text-white"]); ?>

	<div class="my-3">
		<div class="text-h6"><a href="lk/" class="text-black">Back</a></div>
	</div>


	<div class="my-3 p-3 border shadow rounded bg-deep-orange text-white">
		<div class="row q-col-gutter-sm justify-between items-center no-wrap">
			<div class="p-3 justify-center border-right">
				<q-icon name="school" size="md"></q-icon>
			</div>
			<div class="p-3 justify-center"><span class="title2">Activity Template</span></div>

		</div>
	</div>



	<div class="my-5">
		<div class="text-h3">Activity title</div>
		<hr>
		<div class="subtitle1 text-grey">{{truncate(lorem, 100, "")}}</div>
		<div class="my-3"><q-img
			src="img/intellect/inn1.jpg"
			spinner-size="20px"
		/></div>

		<div class="my-3 text-h6">
			{{lorem}}
		</div>
		<div class="my-5 text-center">
			<q-btn color="deep-orange" size="lg" icon="check" label="Subscribe" @click="onClick" ></q-btn>
		</div>

	</div>


	<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>