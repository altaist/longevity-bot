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
				<div class="row q-gutter-lg justify-end items-center">
					<div><a href="#solution" class="text-h6 menu-item" @click.prevent="scrollTo('solution')">Solution</a></div>
					<div><a href="#science" class="text-h6 menu-item" @click.prevent="scrollTo('science')">Science</a></div>
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
				<div class="row q-gutter-lg justify-between items-center">
					<div><a href="#solution" class="text-h6 menu-item" @click.prevent="scrollTo('solution')">Solution</a></div>
					<div><a href="#science" class="text-h6 menu-item" @click.prevent="scrollTo('science')">Science</a></div>
					<div><a href="#about" class="text-h6 menu-item" @click.prevent="scrollTo('about')">About us</a></div>
				</div>
			</div>
			<div class="col-12 col-md-2 text-center">
				<div class="menu-item">
					<q-btn color="orange" size="md" label="Contact us" @click="scrollTo('feedback')"></q-btn>
				</div>

			</div>

		</div>
	</div>

	<div class="my-3 bg-grey-2 rounded">
		<div class="row q-col-gutter-sm reverse ">
			<div class="col-12 col-md-6 ">
				<div class="animated fadeInRight">
					<q-img src="img/lh/new/1.jpg" class="rounded" height="400px" spinner-color="primary" spinner-size="82px"></q-img>

				</div>
			</div>
			<div class="col-12 col-md-6 text-left">
				<div class="p-4 animated fadeInLeft">
					<div class="my-5 text-h4"><b>Aging better, living longer</b></div>
					<div class="my-1 text-h6">90% of our longevity depends on our lifestyle. <span class="text-h6">Meet the digital companion that will support your healthy behaviors!</span></div>

					<div class="my-3">
						<q-btn color="orange" label="Sign up" size="lg" @click="scrollTo('feedback')"></q-btn>
					</div>

				</div>
			</div>

		</div>
	</div>
	<div class="my-5 p-3 rounded color-block3 text-center bg-orange shadow">
		<div class="text-h5">Learn and thrive with our webinar</div>
		<div class="my-2 text-h5"><b>Switching to healthier habits when you are over 50: challenges & opportunities</b></div>
		<div class="my-3">
			<hr>
		</div>
		<div class="mt-3 text-h6"></div>
		<div class="mt-3 text-h6">With age, unealthy habits turn into unhealthy routines, and may become difficult to change.
This interactive webinar will introduce insights and science-proved methods to behavior change for those over 50 years old.
Participants will look at their lifestyles through a prism of psychology and behavioral science, understand some of their decisions and what drives them.
At the outcome participants will get basic tools and approaches to support their change towards healthier lifestyles.</div>

		<div class="mt-3">
			<q-btn color="black" label="Sign up" size="lg" href="https://www.eventbrite.com/e/what-will-i-do-once-i-retire-how-to-decide-better-tickets-444003665917"></q-btn>
		</div>
	</div>
	<div id="solution" class="my-5 p-3 rounded color-block1 text-center text-h5 animated fadeInRight">
		Combining Artificial Intelligence and Behavioral Science to empower healthy behaviors and healthy lifestyles
	</div>
	<div class="my-5 py-3">

		<div class="row q-col-gutter-md animated fadeInLeft text-h6">
			<div class="col-12 col-md-4 text-center ">
				<div class=""><span class="material-icons text-h1 color hov">
						self_improvement
					</span></div>
				<div>Prevention and precision health</div>

			</div>
			<div class="col-12 col-md-4 text-center">
				<div class="hov"><span class="material-icons text-h1 color hov">
						person
					</span>
				</div>
				<div>Personalization</div>

			</div>
			<div class="col-12 col-md-4 text-center ">
				<div class="hov"><span class="material-icons text-h1 color hov">
						diversity_3
					</span></div>
				<div> Focused on behavior
				</div>
			</div>
		</div>
	</div>

	<div class="my-5 p-3 rounded color-block1 text-left text-h5">
		<div class="text-h4 text-white">IOT, AI and Behavioral Informatics
		</div>
		<div class="mb-5 text-h6 text-white">applied to life</div>
		<hr>
		<div class="row q-col-gutter-lg">
			<div class="col-12 col-md-4 text-h6 hov">
				Real-time behavioral and biomedical data
			</div>
			<div class="col-12 col-md-4 text-h6 hov">
				Dynamic personalization & coaching
			</div>
			<div class="col-12 col-md-4 text-h6 hov">
				Social connections & communities
			</div>

		</div>
	</div>
	<div class="my-5">
		<hr>
	</div>
	<div class="my-3 p-3 px-5 rounded color-block1 text-center text-h4" style="min-height: 200px;">
		<div class="my-3 text-h3">Step by step on how it works</div>
		<hr>
		<div class="my-5">
			<div class="my-2 color-block1-rev rounded hov2 p-2">
				<div class="row q-col-gutter-md items-center ">
					<div class="col-12 col-md-4 text-h2 text-right ">
						<div class="p-3 text-h2 border-right">1</div>
					</div>
					<div class="col-12 col-md-6 text-h5 text-left pl-3">
						Register to start your journey to healthier lifestyle
					</div>
				</div>
			</div>
			<div class="my-2 color-block1-rev rounded hov2 p-2">
				<div class="row q-col-gutter-md items-center ">
					<div class="col-12 col-md-4 text-h2 text-right ">
						<div class="p-3 text-h2 border-right">2</div>
					</div>
					<div class="col-12 col-md-6 text-h5 text-left pl-3">
						Tell us a little about yourself
					</div>
				</div>
			</div>
			<div class="my-2 color-block1-rev rounded hov2 p-2">
				<div class="row q-col-gutter-md items-center ">
					<div class="col-12 col-md-4 text-h2 text-right ">
						<div class="p-3 text-h2 border-right">3</div>
					</div>
					<div class="col-12 col-md-6 text-h5 text-left pl-3">
						Start with a few objectives
					</div>
				</div>
			</div>
			<div class="my-2 color-block1-rev rounded hov2 p-2">
				<div class="row q-col-gutter-md items-center ">
					<div class="col-12 col-md-4 text-h2 text-right ">
						<div class="p-3 text-h2 border-right">4</div>
					</div>
					<div class="col-12 col-md-6 text-h5 text-left pl-3">
						Let's interact
					</div>
				</div>
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
					<div class="my-2 text-h4 text-center">Why empowering healthy behaviors?</div>
					<p>Once we reach the age of 65 we could expect to live on average additional 20 years. That's the good news.

						9 of those years will be spend in poor health and the tendency says we will keep living longer with declined health. That's the bad news.</p>
				</div>
			</div>
			<div class="my-5 row q-col-gutter-lg ">

				<div class="col-12 col-md-6 text-h6">
					<div class="my-2 text-h4">Behavior factors influence health span</div>
					<div>The more risk habits we incorporate in our routines the greater impact on our health.</div>
				</div>
				<div class="col-12 col-md-6 text-h6">
					<q-img src="img/lh/new/3.jpg" class="rounded" height="300px" spinner-color="primary" spinner-size="82px"></q-img>
				</div>
			</div>
			<div class="my-5 row q-col-gutter-lg reverse">

				<div class="col-12 col-md-6 text-h6">
					<div class="my-2 text-h4">Behavior change is within your reach</div>
					<div>We assist you in overcoming behavioral barriers to healthier habits, and increasing your intrinsic motivation for healthier lifestyles. We help to diminish barriers that are a struggle when trying to improve habits</div>

				</div>
				<div class="col-12 col-md-6 text-h6">
					<q-img src="img/lh/new/4.jpg" class="rounded" height="300px" spinner-color="primary" spinner-size="82px"></q-img>
				</div>
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

	<!--div class="my-3 p-3 rounded color-block2 text-center text-h5">
		<div class="text-h5">Gain healthy habits</div>
		<div class="text-h6">Sign up now</div>
	</div-->

	<div class="my-3 p-3 rounded color-block3 text-center text-h5 bg-orange">
		<div class="text-h5">Let's build together a retirement tribe!</div>
		<div class="text-h6">Write us to discover how can we collaborate with you and your company.</div>
	</div>
	<div id="feedback" class="my-5">
		<?php
		$view->component("user/feedback", ["color" => "secondary", "btn-ok-label" => "Create companion"]);
		?>
	</div>

	<div id="about" class="my-3">
		<div class="text-h4 color">Our partners</div>
		<hr>
		<div class="row q-col-gutter-lg justify-center q-ma-md">
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.euratechnologies.com/" target="top"><img src="img/lh/euro.svg" width="200"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.eurasante.com/" target="top"><img src="img/lh/es.svg" width="200"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://www.eurasenior.fr/" target="top"><img src="img/lh/eurasenior.png" width="200"></a>
			</div>
			<div class="col-12 col-md-6 text-center">
				<a href="https://swissinsurtech.com/start-ups/" target="top"><img src="img/lh/swiss.png" width="200"></a>
			</div>
		</div>
	</div>

	<div class="mt-5 mb-0">
		<q-img src="img/lh/img5.jpg" height="300px">
			<div class="absolute-full flex flex-center text-h4 text-center">
				Research center, insurance, retirement funds?<br>
				Reach out to collaborate
			</div>
		</q-img>
	</div>
	<div class="mt-0 mb-0 p-3 menu">
		<div class="row q-col-gutter-sm">
			<div class="col-12 col-md-4 text-left">&copy; Longevity Hub, 2023</div>

		</div>
	</div>

</div>


<?php $view->component("footer", ["title" => "", "class" => "menu-footer1"]); ?>