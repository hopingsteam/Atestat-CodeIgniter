<!-- start banner Area -->
	<section class="banner-area relative" id="home">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex text-center align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<p class="text-white link-nav"><a href="index.html">Acasa </a>
						<span class="lnr lnr-arrow-right"></span> <a href="elements.html">
							Inregistreaza</a></p>
					<h1 class="text-white">
						Inregistreaza
					</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->

	<!-- Start Align Area -->
	<section class="whole-wrap">
		<div class="container">
			<div class="section-top-border">
				<div class="row">
					<div class="col-lg-6 col-md-6">
                        <?php echo $this->session->flashdata('msg'); ?>

                        <?php
                        echo form_open("tutorial/process_register");
                        ?>
							<div class="mt-10">
								<input type="text" name="nume" placeholder="Nume" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nume'"
								 required class="single-input">
							</div>
							<div class="mt-10">
								<input type="text" name="prenume" placeholder="Prenume" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Prenume'"
									   required class="single-input">
							</div>
							<div class="mt-10">
								<input type="text" name="username" placeholder="Nume utilizator" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nume utilizator'"
									   required class="single-input">
							</div>
							<div class="mt-10">
								<input type="text" name="email" placeholder="E-Mail" onfocus="this.placeholder = ''" onblur="this.placeholder = 'E-Mail'"
									   required class="single-input">
							</div>
							<div class="mt-10">
								<input type="password" name="password" placeholder="Parola" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Parola'"
								 required class="single-input">
							</div>
                            <div class="mt-10">
                            <input type="password" name="cpassword" placeholder="Repeta Parola" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Repeta Parola'"
                                   required class="single-input">
                            </div>
							<div class="mt-10 text-right">
                                <input name="Inregistrare" type="submit" class="genric-btn primary radius" value="Trimite">
							</div>
                        <?php
                            form_close();
                        ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Align Area -->