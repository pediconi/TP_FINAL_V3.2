<?php 

namespace views;

?>

<div class="pt-3 pb-5">

		<article id="listaProductos" class="container mb-3 px-5 fondo-secondary border-all-primary">

			<header id="headerListaProductos" class="text-center fuente-montserrat">
				<h2>TIKET PRO</h2>
				<p class="color-gray fuente-lato">Artistas.</p>
			</header>

			<section class="row">
				
				<?php 
				if (!empty($artists)){
					echo '<h5> ENTRE AL IF  </h5>';
					var_dump($artists);

					foreach ($artists as $key => $value) { ?>

					<?php echo 'ENTRE AL FOREACH'; ?>

					<article class="col-lg-3 col-md-4 col-sm-6 mb-4">
						
						<div class="card">
							
							<div class="card-footer">
							
								<h5 class="card-title text-center"><?= $value->getName() . " " . $value->getDescription() ?></h5>

								<a href="<?= $value->getPhoto() ?>" data-fancybox="group"  data-from="card" class="card-img-top">
								<img src="<?= $value->getPhoto() ?>" alt="Artista: <?= $value->getName() ?>"/>
								</a>

							
							</div>



						</div>

					</article>

					<?php } 
					
				
			} else {
					echo '<h4> NO TENGO ARTISTAS PARA MOSTRAR! </h4>';
			}
				
				
				?>	

			</section>

		</article>

				
			<footer class="text-center mt-2">
				<a href="<?= FRONT_ROOT ?> artist/addView" class="btn btn-secondary">Agregar Artista</a>
			</footer>

	</div>


