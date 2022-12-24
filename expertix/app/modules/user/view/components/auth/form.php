<?php
$color = $params->get("color", "primary");
?>

<div class="">
	<div class="my-3">
		<div v-if="user && user.userKey">
			<?php $view->component($params->get("", "@user/auth/auth_completed")) ?>
		</div>
		<div v-else>

			<div class="row q-col-gutter-sm" v-if="login.screen=='signup'">
				<div class="col-12">
					<div class="text-h4 text-<?= $color ?> text-left ">Регистрация</div>
					<hr />
				</div>
				<div class="col-12">
					<div class="my-3">
						<q-toggle v-model="login.screen" label="Уже регистрировался" color="<?= $color ?>" true-value="signin" false-value="signup" keep-color></q-toggle>
					</div>
				</div>
				<div class="col-12 col-md-4">
					<q-input v-model="login.firstName" label="Как вас зовут? *" outlined size="lg">
					</q-input>
				</div>
				<div class="col-12 col-md-4">
					<q-input v-model="login.email" label="Email *" outlined size="lg">
					</q-input>
				</div>
				<?php if ($props->check("signup_personal")) { ?>
					<div class="col-12 col-md-4">
						<q-input v-model="login.tel" label="WhatsApp *" outlined size="lg">
						</q-input>
					</div>
				<?php } ?>
				<?php if ($props->check("signup_password")) { ?>
				<?php } ?>

				<div class="col-12 col-md-6">
				</div>
				<div class="col-12 col-md-12 text-right">
					<q-btn label="<?= $params->get("btn-ok-label", "Записаться") ?>" @click="<?= $params->get("btn-ok-action", "onBtnAuthClick(onAuthCompleted)") ?>" size="lg" color="<?= $params->get("btn-ok-color", $color) ?>"></q-btn>
				</div>
			</div>

			<div class="row q-col-gutter-sm" v-if="login.screen=='signin'">
				<div class="col-12">
					<div class="text-h4 text-<?= $color ?> text-left ">Вход в систему</div>
					<hr />
				</div>
				<div class="col-12">
					<div class="my-3">
						<q-toggle v-model="login.screen" label="Уже регистрировался" color="<?= $color ?>" true-value="signin" false-value="signup" keep-color></q-toggle>
					</div>
				</div>
				<?php if ($props->get("signin_method", "password") == "password") { ?>
					<div class="col-12 col-md-12">
						<q-input v-model="login.email" label="Email" outlined size="lg">
						</q-input>
					</div>
					<div class="col-12 col-md-12">
						<q-input v-model="login.password" label="Password" type="password" outlined size="lg">
						</q-input>
					</div>
					<div class="col-6 col-md-6">
					</div>
					<div class="col-12 col-md-12 my-1">
						<q-btn label="<?= $params->get("btn-ok-label", "Войти") ?>" @click="<?= $params->get("btn-ok-action", "onBtnAuthClick(onAuthCompleted)") ?>" size="lg" color="<?= $params->get("btn-ok-color", $color) ?>"></q-btn>
					</div>

				<?php } ?>

				<?php if ($props->get("signin_method", "login") == "email") { ?>
					<div class="col-12">
						<div class="title5 my-3">Введите адрес электрнной почты, указанной при регистрации. Мы отправим вам сообщение с ссылкой для доступа к сервису</div>
					</div>
					<div class="col-12 col-md-6">
						<q-input v-model="login.email" label="Мой email" outlined size="lg">
						</q-input>
					</div>
					<div class="col-12">
						<div class="my-3">
							<q-toggle v-model="login.screen" label="Уже регистрировался" color="<?= $color ?>" true-value="signin" false-value="signup" keep-color></q-toggle>
						</div>
					</div>

					<div class="col-12 col-md-12">
						<q-btn label="Напомнить" @click="notifyEmail(login.email)" color="<?= $color ?>" size="lg"></q-btn>
					</div>
				<?php } ?>


			</div>

			<div class="row" v-if="login.screen=='signin_confirm'">
				<div class="col-12 col-md-6">
					<q-input v-model="login.email" label="Email" outlined size="lg" id="el_login.email">
					</q-input>
				</div>
				<div class="col-12 col-md-6">
				</div>
				<div class="col-12 col-md-6">
					<q-input v-model="login.confirmCode" label="Email" outlined size="lg" id="el_login.confirmCode">
					</q-input>
					Введите код подтверждения, который мы выслали вам по электронной почте
				</div>
				<div class="col-6 col-md-6">
				</div>

				<div class="col-6 col-md-6 my-1 text-right">
					<q-btn label="Войти" @click="" size="lg" color="deep-orange"></q-btn>
				</div>
			</div>

		</div>



	</div>
</div>