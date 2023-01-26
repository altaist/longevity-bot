<?php
$view->component("header", ["title" => "Название проекта", "home_icon" => "home", "home_href" => "'home'", "class" => "menu-top1"]);


?>
<div class="container">
	<div class="mt-2 p-3 menu rounded desktop-only">
		<div class="row q-col-gutter-sm items-center">
			<div class="col-12 col-md-4 text-left">
				<img src="img/med/longevity-logo.png" height="80">
			</div>
			<div class="col-12 col-md-6 text-center">
				<div class="row q-gutter-lg justify-between items-center">
					<div class="col">
						<div class="row justify-start q-gutter-lg items-center">
							<div><a href="https://www.facebook.com/profile.php?id=100086277477674" target="top" class="text-h4 menu-item"><i class="fa-brands fa-facebook"></i></a></div>
							<div><a href="https://www.linkedin.com/company/logevityhubworld/" target="top" class="text-h4 menu-item"><i class="fa-brands fa-linkedin"></i></a></div>
						</div>
					</div>
					<div><a href="#solution" class="text-h6 menu-item" @click.prevent="scrollTo('solution')">Solution</a></div>
					<div><a href="#about" class="text-h6 menu-item" @click.prevent="scrollTo('about')">About us</a></div>
				</div>
			</div>
			<div class="col-12 col-md-2 text-right">
				<div class="menu-item">
					<q-btn color="orange" size="md" label="Contact us" @click="scrollTo('feedback')"></q-btn>
				</div>

			</div>

		</div>
	</div>
	<div class="mt-2 p-3 menu rounded mobile-only">
		<div class="row q-col-gutter-sm items-center">
			<div class=" col-12 col-md-4 text-center">
				<div><img src="img/med/longevity-logo.png" height="80"></div>
			</div>
			<div class="col-12 col-md-6 text-center">
				<div class="row q-gutter-lg justify-center items-center">
					<div><a href="#solution" class="text-h6 menu-item" @click.prevent="scrollTo('solution')">Solution</a></div>
					<div><a href="#about" class="text-h6 menu-item" @click.prevent="scrollTo('about')">About us</a></div>
				</div>
			</div>
			<div class="col-12 col-md-2 text-center">
				<div class="row justify-center q-gutter-lg items-center">
					<div class="menu-item">
						<q-btn color="orange" size="md" label="Contact us" @click="scrollTo('feedback')"></q-btn>
					</div>
					<div><a href="https://www.facebook.com/profile.php?id=100086277477674" target="top" class="text-h4 menu-item"><i class="fa-brands fa-facebook"></i></a></div>
					<div><a href="https://www.linkedin.com/company/logevityhubworld/" target="top" class="text-h4 menu-item"><i class="fa-brands fa-linkedin"></i></a></div>
				</div>


			</div>

		</div>
	</div>

	<div class="my-3 bg-grey-2 rounded">
		<div class="row q-col-gutter-sm reverse ">
			<div class="col-12 col-md-6 ">
				<div class="animated fadeInRight">
					<q-img src="img/lh/banner1.jpg" class="rounded" spinner-color="primary" spinner-size="82px"></q-img>

				</div>
			</div>
			<div class="col-12 col-md-6 text-left">
				<div class="p-4 animated fadeInLeft">
					<div class="mt-3 mb-5 text-h4"><b>Aging better, living longer</b></div>
					<div class="my-1 text-h6">90% of our longevity depends on our lifestyle. <span class="text-h6">Meet the digital companion that will empower your healthy behaviors!</span></div>

					<div class="my-3">
						<q-btn color="orange" label="Sign up and test our solution for free" size="lg" @click="scrollTo('feedback')"></q-btn>
					</div>

				</div>
			</div>

		</div>
	</div>
	<div class="">
		<div class="text-h4"></div>
		<q-img src="img/lh/banner2.jpg" class="rounded" height="100%" spinner-color="primary" @click.prevent="scrollTo('feedback')"></q-img>
	</div>
	<div id="about" class="my-5">
		<div class="text-h4 color">Our partners</div>
		<hr>
		<div class="row q-col-gutter-lg justify-center q-ma-md">
			<div class="col-12 col-md-6 text-center">
				<a href="https://swissinsurtech.com/start-ups/" target="top"><img src="img/lh/swiss.png" width="300"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.eurasante.com/" target="top"><img src="img/lh/es.svg" width="300"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.eurasenior.fr/" target="top"><img src="img/lh/eurasenior.png" width="300"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.euratechnologies.com/" target="top"><img src="img/lh/euro.svg" width="300"></a>

			</div>
		</div>
	</div>
	<div id="about" class="my-5">
		<div class="text-h4 color">About us</div>
		<hr>
		<div class="">
			<div class="row q-col-gutter-md mt-3">
				<div class="col-12 col-md-6 p-md-2">
					<center><img src="img/med/nedelskiy.jpg" height="300" style="border-radius: 50%;">
						<div class="text-h5 mt-3">Vitaly Nedelskiy</div>
						<div class="text-h6 mt-3">Founder, President</div>
					</center>
					<div>
					</div>
				</div>
				<div class="col-12 col-md-6 p-md-2">
					<center><img src="img/med/uliana.jpg" height="300" style="border-radius: 50%;">
						<div class="text-h5 mt-3">Uliana Shchelgacheva</div>
						<div class="text-h6 mt-3">Founder, CEO</div>
					</center>
					<ul>
					</ul>
				</div>
				<!--div class="col-12 col-md-4 p-md-2">
					<center><img src="img/med/pecherskiy.jpg" height="300" style="border-radius: 50%;">
						<div class="text-h5 mt-3">Alex Pecherskiy</div>
						<div class="text-h6 mt-3">Founder, CTO</div>
					</center>
					<ul>
					</ul>
				</div-->
			</div>
		</div>
	</div>
	<div class="my-5">
		<hr>
	</div>

	<div id="science" class="my-5">

		<div class="my-0">
			<div class="my-0 row q-col-gutter-lg">
				<div class="col-12 col-md-6 text-h6">
					<q-img src="img/lh/new/2.jpg" class="rounded" height="300px" spinner-color="primary" spinner-size="82px"></q-img>
				</div>
				<div class="col-12 col-md-6 text-h6">
					<div class="my-2 text-h5"><b>Why empowering healthy behaviors?</b></div>
					<div class="my-3">Once we reach the age of 65 we could expect to live on average additional 20 years. That's the good news. 9 of those years will be spend in poor health and the tendency says we will keep living longer with declined health. That's the bad news.</div>
				</div>
			</div>
			<div class="my-5 row q-col-gutter-lg ">

				<div class="col-12 col-md-6 text-h6">
					<div class="my-2 text-h5"><b>Behavior factors influence health span</b></div>
					<div class="my-3">The more risk habits we incorporate in our routines the greater impact on our health.</div>
				</div>
				<div class="col-12 col-md-6 text-h6">
					<q-img src="img/lh/new/3.jpg" class="rounded" height="300px" spinner-color="primary" spinner-size="82px"></q-img>
				</div>
			</div>
			<div class="my-5 row q-col-gutter-lg reverse">

				<div class="col-12 col-md-6 text-h6">
					<div class="my-2 text-h5"><b>Behavior change is within your reach</b></div>
					<div class="my-3">We assist you in overcoming behavioral barriers to healthier habits, and increasing your intrinsic motivation for healthier lifestyles. We help to diminish barriers that are a struggle when trying to improve habits</div>

				</div>
				<div class="col-12 col-md-6 text-h6">
					<q-img src="img/lh/new/4.jpg" class="rounded" height="300px" spinner-color="primary" spinner-size="82px"></q-img>
				</div>
			</div>

		</div>

	</div>

	<!--div class="my-3 p-3 rounded color-block2 text-center text-h5">
		<div class="text-h5">Gain healthy habits</div>
		<div class="text-h6">Sign up now</div>
	</div-->
	<div class="mt-5 mb-0 color-block1 p-5  ">
		<div class="text-h5 text-center text-white flex flex-center">
			We believe in building partnerships<br>
			Does your organization work with senior adults?<br>
			Reach out to connect
		</div>
		<div class="mt-3 text-center"><q-btn color="orange" size="lg" label="Contact us" @click="scrollTo('feedback')"></q-btn></div>

	</div>

	<div class="mb-3 p-3 color-block3 text-center text-h5 bg-orange">
		<div class="text-h5">Let's build together a retirement tribe!</div>
		<div class="text-h6">Write us to discover how can we collaborate with you and your company.</div>
	</div>
	<div id="feedback" class="my-5">
		<?php
		$view->component("user/feedback", ["color" => "secondary", "btn-ok-label" => "Create companion"]);
		?>
	</div>

	<div class="mt-0 mb-0 p-3 menu">
		<div class="row q-col-gutter-md">
			<div class="col-6 col-md-4 text-left">&copy; Longevity Hub, 2023</div>
			<div class="col-6 col-md-8 text-right">
				<a href="https://www.facebook.com/profile.php?id=100086277477674" target="top" class="text-h4 menu-item"><i class="fa-brands fa-facebook mr-3"></i></a>
				<a href="https://www.linkedin.com/company/logevityhubworld/" target="top" class="text-h4 menu-item"><i class="fa-brands fa-linkedin"></i></a>
			</div>
		</div>
	</div>
</div>

</div>


<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>