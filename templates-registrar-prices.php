<?php 
/**
 * Template Name: Registrar Prices
 */

get_header(); ?>

<?php

global $wpdb;

// Prices
$sql = '
	SELECT 
		id , 
		name , 
		tld , 
		price , 
		`default` , 
		notes 
	FROM 
		orbis_domain_names_prices
	ORDER BY 
		`default` DESC , 
		tld 
';

$prices = $wpdb->get_results( $sql );

?>
<h1>Prijzen</h1>

<div class="panel">
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Id</th>
				<th scope="col">Naam</th>
				<th scope="col"><abbr title="Top Level Domain">TLD</abbr></th>
				<th scope="col">Prijs</th>
				<th scope="col">Standaard</th>
				<th scope="col">Opmerking</th>
			</tr>
		</thead>
	
		<tbody>
	
			<?php foreach($prices as $price): ?>
	
			<tr>
	
				<td><?php echo $price->id; ?></td>
				<td><?php echo $price->name; ?></td>
				<td><?php echo $price->tld ?></td>
				<td>&euro; <?php echo number_format($price->price, 2, ',', '.'); ?></td>
				<td><?php echo $price->default ? 'Ja' : ''; ?></td>
				<td><?php echo nl2br($price->notes); ?></td>
	
			</tr>
	
			<?php endforeach; ?>
	
		</tbody>
	</table>
</div>

<?php

// Prices
$sql = '
	SELECT 
		id , 
		name , 
		price , 
		notes 
	FROM 
		orbis_hosting_packages
';

$prices = $wpdb->get_results( $sql );

?>
<h1>Prijzen</h1>

<div class="panel">
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Id</th>
				<th scope="col">Naam</th>
				<th scope="col">Prijs</th>
				<th scope="col">Opmerking</th>
			</tr>
		</thead>
	
		<tbody>
	
			<?php foreach($prices as $price): ?>
	
			<tr>
	
				<td><?php echo $price->id; ?></td>
				<td><?php echo $price->name; ?></td>
				<td>&euro; <?php echo number_format($price->price, 2, ',', '.'); ?></td>
				<td><?php echo nl2br($price->notes); ?></td>
	
			</tr>
	
			<?php endforeach; ?>
	
		</tbody>
	</table>
</div>

<?php get_footer(); ?>