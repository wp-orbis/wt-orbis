<?php 
/**
 * Template Name: Registrar
 */

get_header(); ?>

<?php


class Domain {
	private $root;

	private $aliases;

	public $cancelDate;

	public function __construct() {
		$this->aliases = array();
	}

	public function isCanceled() {
		return $this->cancelDate != null;
	}

	public function addAlias(Domain $domain) {
		$domain->root = $this;

		$this->aliases[$domain->id] = $domain;
	}

	public function hasAliases() {
		return !empty($this->aliases);
	}

	public function getRoot() {
		return $this->root;
	}

	public function getAliases() {
		return $this->aliases;
	}

	public function isAlias() {
		return $this->root != null;
	}

	public function getName() {
		if($this->package != null) {
			return sprintf('Webhosting');
		} else {
			return sprintf('Domeinhosting');
		}
	}
}

class GoogleApps {
	private $created;

	public function getCreated() {
		return $this->created;
	}

	public function setCreated(DateTime $created = null) {
		$this->created = $created;
	}

	public function isCreated() {
		return $this->created != null;
	}
}

function findDomainsByQuery($pdo, $query) {
	$statement = $pdo->prepare($query);
	$statement->execute();

	$data = $statement->fetchAll(PDO::FETCH_CLASS);

	$timezone = new DateTimeZone('Europe/Amsterdam');

	$priceTotalDomains = 0;
	$priceTotalPackages = 0;
	$priceTotal = 0;

	$domains = array();
	foreach($data as $d) {
		$domain = new Domain();
		$domain->id = $d->id;
		$domain->name = $d->name;

		$domain->deliveryDate = null;
		if($d->deliveryDate) {
			$domain->deliveryDate = new DateTime($d->deliveryDate, $timezone);
		}

		$domain->cancelDate = null;
		if($d->cancelDate) {
			$domain->cancelDate = new DateTime($d->cancelDate, $timezone);
		}

		$domain->registrar = null;
		if($d->registrarId) {
			$domain->registrar = new stdClass();
			$domain->registrar->id = $d->registrarId;
			$domain->registrar->name = $d->registrarName;
		}

		$domain->registrarCreditor = null;
		if($d->registrarCreditorId) {
			$domain->registrarCreditor = new stdClass();
			$domain->registrarCreditor->id = $d->registrarCreditorId;
			$domain->registrarCreditor->name = $d->registrarCreditorName;
		}

		$domain->client = null;
		if($d->clientId) {
			$domain->client = new stdClass();
			$domain->client->id = $d->clientId;
			$domain->client->name = $d->clientName;
		}

		$domain->managerDns = null;
		if($d->managerDnsId) {
			$domain->managerDns = new stdClass();
			$domain->managerDns->id = $d->managerDnsId;
			$domain->managerDns->name = $d->managerDnsName;
		}

		$domain->managerMail = null;
		if($d->managerMailId) {
			$domain->managerMail = new stdClass();
			$domain->managerMail->id = $d->managerMailId;
			$domain->managerMail->name = $d->managerMailName;
		}

		$domain->price = $d->domainPrice;
		$domain->tld = $d->domainTld;
		$domain->openproviderPrice = $d->domainOpenproviderPrice;
		$priceTotalDomains += $domain->price;
		$priceTotal += $domain->price;

		$domain->package = null;
		if($d->packageId) {
			$domain->package = new stdClass();
			$domain->package->id = $d->packageId;
			$domain->package->name = $d->packageName;
			$domain->package->price = $d->packagePrice;

			if(!$domain->isCanceled()) {
				$priceTotalPackages += $d->packagePrice;
				$priceTotal += $d->packagePrice;
			}
		}

		// Google Apps
		$domain->googleApps = new GoogleApps();
		$domain->googleApps->edition = $d->googleAppsEdition;
		$domain->googleApps->domain = $domain;
		$domain->googleApps->adminUsername = $d->googleAppsAdminUsername;
		if($d->googleAppsCreated) {
			$domain->googleApps->setCreated(new DateTime($d->googleAppsCreated, $timezone));
		}
		$domain->googleApps->mxRecords = (bool) $d->googleAppsMxRecords;
		$domain->googleApps->spfRecord = (bool) $d->googleAppsSpfRecord;
		$domain->googleApps->mailActive = (bool) $d->googleAppsMailActive;

		// Google Webmaster Tools
		$domain->googleWebmasterTools = (bool) $d->googleWebmasterTools;

		// Google Analytics tracking code
		$domain->googleAnalytics = null;
		if(isset($d->googleAnalyticsTrackingCode, $d->googleAnalyticsId)) {
			$domain->googleAnalytics = new stdClass();
			$domain->googleAnalytics->trackingCode = $d->googleAnalyticsTrackingCode;
			$domain->googleAnalytics->id = $d->googleAnalyticsId;
		}

		// Orbis
		$domain->orbisPrice = $d->orbisPrice;

		$domains[$d->id] = $domain;
	}

	// Find aliases
	foreach($data as $d) {
		$alias = $domains[$d->id];

		if($d->rootId && isset($domains[$d->rootId])) {
			$root = $domains[$d->rootId];

			$root->addAlias($alias);
		}

		if($d->googleAppsRootId && isset($domains[$d->googleAppsRootId])) {
			$root = $domains[$d->googleAppsRootId];

			$alias->googleApps = $root->googleApps;
		}
	}

	return $domains;
}

function findAllDomains($pdo) {
	// Domains
	$query = '
		SELECT
			domain_name.id , 
			domain_name.domain_name AS name , 

			registrar.id AS registrarId , 
			registrar.name AS registrarName , 

			registrar_creditor.id AS registrarCreditorId , 
			registrar_creditor.name AS registrarCreditorName , 

			client.id AS clientId , 
			client.name AS clientName , 

			manager_dns.id AS managerDnsId , 
			manager_dns.name AS managerDnsName , 

			manager_mail.id AS managerMailId , 
			manager_mail.name AS managerMailName , 

			domain_name.root_id AS rootId , 

			domain_name.order_date AS deliveryDate , 
			domain_name.cancel_date AS cancelDate , 

			price.price AS domainPrice , 
			price.openprovider_price AS domainOpenproviderPrice , 
			price.tld AS domainTld , 

			package.id AS packageId , 
			package.name AS packageName , 
			package.price AS packagePrice , 

			domain_name.google_apps_root_id AS googleAppsRootId , 
			domain_name.google_apps_edition AS googleAppsEdition , 
			domain_name.google_apps_created AS googleAppsCreated , 
			domain_name.google_apps_admin_username AS googleAppsAdminUsername , 
			domain_name.google_apps_mx_records AS googleAppsMxRecords , 
			domain_name.google_apps_spf_record AS googleAppsSpfRecord , 
			domain_name.google_apps_mail_active AS googleAppsMailActive , 
			domain_name.google_webmaster_tools AS googleWebmasterTools , 
			domain_name.google_analytics_tracking_code AS googleAnalyticsTrackingCode , 
			domain_name.google_analytics_id AS googleAnalyticsId , 

			domain_name.orbis_price AS orbisPrice 
		FROM
			orbis_domain_names AS domain_name
				LEFT JOIN
			orbis_companies AS registrar
					ON domain_name.registrar_id = registrar.id 
				LEFT JOIN
			orbis_companies AS registrar_creditor
					ON domain_name.registrar_creditor_id = registrar_creditor.id 
				LEFT JOIN
			orbis_companies AS client
					ON domain_name.client_id = client.id 
				LEFT JOIN
			orbis_companies AS manager_dns
					ON domain_name.manager_dns_id = manager_dns.id 
				LEFT JOIN
			orbis_companies AS manager_mail
					ON domain_name.manager_mail_id = manager_mail.id 
				LEFT JOIN
			orbis_domain_names_prices AS price
					ON domain_name.price_id = price.id 
				LEFT JOIN
			orbis_hosting_packages AS package
					ON domain_name.package_id = package.id 
		ORDER BY
			domain_name ;
	';

	return findDomainsByQuery($pdo, $query);
}

function findAllDomainsForClient($pdo, $id) {
	// Domains
	$query = '
		SELECT
			domain_name.id , 
			domain_name.domain_name AS name , 

			registrar.id AS registrarId , 
			registrar.name AS registrarName , 

			registrar_creditor.id AS registrarCreditorId , 
			registrar_creditor.name AS registrarCreditorName , 

			client.id AS clientId , 
			client.name AS clientName , 

			manager_dns.id AS managerDnsId , 
			manager_dns.name AS managerDnsName , 

			manager_mail.id AS managerMailId , 
			manager_mail.name AS managerMailName , 

			domain_name.root_id AS rootId , 

			domain_name.order_date AS deliveryDate , 
			domain_name.cancel_date AS cancelDate , 

			price.price AS domainPrice , 
			price.openprovider_price AS domainOpenproviderPrice , 
			price.tld AS domainTld , 

			package.id AS packageId , 
			package.name AS packageName , 
			package.price AS packagePrice , 

			domain_name.google_apps_root_id AS googleAppsRootId , 
			domain_name.google_apps_edition AS googleAppsEdition , 
			domain_name.google_apps_created AS googleAppsCreated , 
			domain_name.google_apps_admin_username AS googleAppsAdminUsername , 
			domain_name.google_apps_mx_records AS googleAppsMxRecords , 
			domain_name.google_apps_spf_record AS googleAppsSpfRecord , 
			domain_name.google_apps_mail_active AS googleAppsMailActive , 
			domain_name.google_webmaster_tools AS googleWebmasterTools , 
			domain_name.google_analytics_tracking_code AS googleAnalyticsTrackingCode , 
			domain_name.google_analytics_id AS googleAnalyticsId , 

			domain_name.orbis_price AS orbisPrice 
		FROM
			orbis_domain_names AS domain_name
				LEFT JOIN
			orbis_companies AS registrar
					ON domain_name.registrar_id = registrar.id 
				LEFT JOIN
			orbis_companies AS registrar_creditor
					ON domain_name.registrar_creditor_id = registrar_creditor.id 
				LEFT JOIN
			orbis_companies AS client
					ON domain_name.client_id = client.id 
				LEFT JOIN
			orbis_companies AS manager_dns
					ON domain_name.manager_dns_id = manager_dns.id 
				LEFT JOIN
			orbis_companies AS manager_mail
					ON domain_name.manager_mail_id = manager_mail.id 
				LEFT JOIN
			orbis_domain_names_prices AS price
					ON domain_name.price_id = price.id 
				LEFT JOIN
			orbis_hosting_packages AS package
					ON domain_name.package_id = package.id 
		WHERE
			client.id = %d
		ORDER BY
			domain_name ;
	';

	$query = sprintf($query, $id);

	return findDomainsByQuery($pdo, $query);
}

/* Connect to an ODBC database using driver invocation */
$dsn = 'mysql:dbname=pronamic_nl_orbis;host=mysql-2.pronamic.nl';
$user = 'pronamic_nl_2';
$password = 'Yupa6ep3uspatEp8';

$pdo = new PDO($dsn, $user, $password);
$pdo->exec('SET CHARACTER SET utf8');

// Timezone
date_default_timezone_set('Europe/Amsterdam');

$domains = findAllDomains($pdo);

$priceTotalDomains = 0;
$priceTotalPackages = 0;
$priceTotal = 0;
$opTotal = 0;

foreach($domains as $domain) {
	if(!$domain->isCanceled()) {
		$priceTotalDomains += $domain->price;
		$priceTotal += $domain->price;
		$opTotal += $domain->openproviderPrice;

		if($package = $domain->package) {
			$priceTotalPackages += $package->price;
			$priceTotal += $package->price;
		}
	}
}

?>
		<h1>Registrar</h1>

		<p>
			<a href="http://www.google.com/a/cpanel/domain/new">New Google Apps</a>
		</p>

		<table id="domains-table">
			<thead>
				<tr>
					<th scope="col" colspan="8"></th>
					<th scope="col" colspan="2">Domein</th>
					<th scope="col"></th>
					<th scope="col"></th>
					<th scope="col" colspan="2">Verantwoordelijken</th>
					<th scope="col"></th>
					<th scope="col" colspan="10">Google</th>
					<th scope="col"></th>
				</tr>
				<tr>
					<th scope="col"></th>
					<th scope="col">#</th>
					<th scope="col"></th>
					<th scope="col">Domein</th>
					<th scope="col">Klant</th>
					<th scope="col">Pakket</th>
					<th scope="col">Registrar</th>
					<th scope="col">Opleverdatum</th>
					<th scope="col">Domein</th>
					<th scope="col">Openprovider</th>
					<th scope="col">Hosting</th>
					<th scope="col">Totaal</th>
					<th scope="col">DNS</th>
					<th scope="col">Mail</th>
					<th scope="col">MX</th>
					<th scope="col" colspan="9">Apps</th>
					<th scope="col"><img src="/styles/icons/Google-Webmaster.ico" alt="Webmaster Tools" width="16" height="16" /></th>
					<th scope="col">Analytics</th>
					<th scope="col">Orbis</th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<td colspan="8"></td>
					<th scope="col">Domein</td>
					<th scope="col">Openprovider</td>
					<th scope="col">Hosting</td>
					<th scope="col">Totaal</td>
					<td colspan="15"></td>
				</tr>
				<tr>
					<td>
						<input id="check-all-checkbox" name="domains" value="all" type="checkbox" />
					</td>
					<td colspan="7">
						<button id="check-ga-tracking-code-button" name="check" type="submit">Controleer Generator en Google Analytics tracking code</button>
						<button id="check-ga-tracking-code-button" name="check" type="submit">Controleer Orbis versie</button>
					</td>
					<td>
						&euro;&nbsp;<?php echo number_format($priceTotalDomains, 2, ',', '.'); ?>
					</td>
					<td>
						&euro;&nbsp;<?php echo number_format($opTotal, 2, ',', '.'); ?>
					</td>
					<td>
						&euro;&nbsp;<?php echo number_format($priceTotalPackages, 2, ',', '.'); ?>
					</td>
					<td>
						&euro;&nbsp;<?php echo number_format($priceTotal, 2, ',', '.'); ?>
					</td>
					<td colspan="14"></td>
				</tr>
			</tfoot>

			<tbody>

				<?php 

				$i = 0; 
				$number = 0;

				?>
				

				<?php foreach($domains as $domain): ?>

				<tr id="domein-<?php echo $domain->name; ?>" class="<?php echo $i++ % 2 == 0 ? 'odd' : 'even'; ?> <?php if($domain->isCanceled()): ?>canceled<?php endif; ?>">
					<?php $googleApps = $domain->googleApps; ?>

					<td>
						<input class="id-field" name="domains[<?php echo $domain->id; ?>][id]" value="<?php echo $domain->id; ?>" type="checkbox" />
						<input class="name-field" name="domains[<?php echo $domain->id; ?>][name]" value="<?php echo $domain->name; ?>" type="hidden" />
					</td>
					<td>
						<a href="#domein-<?php echo $domain->name; ?>">
							<?php 
							
							if(!$domain->isCanceled()) {
								echo ++$number;
							} else {
								echo '-';
							}

							?>
						</a>
					</td>
					<td>
						<a href="http://<?php echo $domain->name; ?>/">
							<img src="https://s2.googleusercontent.com/s2/favicons?domain_url=http://<?php echo $domain->name; ?>/" alt="" />
						</a>
					</td>
					<td title="<?php echo $domain->name; ?> [<?php echo $domain->id; ?>]">
						<a href="http://<?php echo $domain->name; ?>/"><?php echo $domain->name; ?></a>

						<?php if($domain->isAlias()): ?>

						<a href="#domein-<?php echo $domain->getRoot()->name; ?>">&raquo;</a>

						<?php endif; ?>
					</td>
					<td>
						<?php if($client = $domain->client): ?>

						<a href="http://orbis.pronamic.nl/bedrijven/details/<?php echo $client->id; ?>/">
							<?php echo htmlentities($client->name, ENT_COMPAT, 'UTF-8'); ?>
						</a>

						<?php else: ?>

						<em>Onbekend</em>

						<?php endif; ?>
					</td>
					<td class="name">
						<?php echo $domain->getName(); ?>
					</td>
					<td>
						<?php if($registrar = $domain->registrar): ?>

						<a href="http://orbis.pronamic.nl/bedrijven/details/<?php echo $registrar->id; ?>/">
							<?php echo htmlentities($registrar->name, ENT_COMPAT, 'UTF-8'); ?>
						</a>

						<?php else: ?>

						<em>Onbekend</em>

						<?php endif; ?>
					</td>
					<td class="time">
						<?php if($domain->deliveryDate): ?>

						<?php echo $domain->deliveryDate->format('d-m-Y H:i'); ?>

						<?php endif; ?>
					</td>
					<td class="price">
						<?php 

						$tp = 0;

						if($price = $domain->price) {
							$tp += $price;

							echo '&euro; ', number_format($price, 2, ',', '.');
						} else {
							echo '<em>?</em>';
						}

						?>
					</td>
					<td class="price">
						<?php

						if($price = $domain->openproviderPrice) {
							echo '&euro; ', number_format($price, 2, ',', '.');
						} else {
							echo '<em>?</em>';
						}

						?>
					</td>
					<td class="price">
						<?php 

						if($package = $domain->package) {
							$tp += $package->price;

							echo '&euro; ', number_format($package->price, 2, ',', '.');
						} else {
						
						}

						?>
					</td>
					<td class="price">
						&euro; <?php echo number_format($tp, 2, ',', '.'); ?>
					</td>
					<td>
						<?php if($managerDns = $domain->managerDns): ?>

						<a href="http://orbis.pronamic.nl/bedrijven/details/<?php echo $managerDns->id; ?>/">
							<?php echo htmlentities($managerDns->name, ENT_COMPAT, 'UTF-8'); ?>
						</a>

						<?php else: ?>

						<em>Onbekend</em>

						<?php endif; ?>
					</td>
					<td>
						<?php if($managerMail = $domain->managerMail): ?>

						<a href="http://orbis.pronamic.nl/bedrijven/details/<?php echo $managerMail->id; ?>/">
							<?php echo htmlentities($managerMail->name, ENT_COMPAT, 'UTF-8'); ?>
						</a>

						<?php else: ?>

						<em>Onbekend</em>

						<?php endif; ?>
					</td>
					<td>
						<?php $parameters = array('action' => 'mx:' . $domain->name); ?>

						<a href="http://www.mxtoolbox.com/SuperTool.aspx?<?php echo http_build_query($parameters, '', '&amp;'); ?>">
							MX
						</a>
					</td>

					<?php if($googleApps->isCreated()): ?>

					<td>
						<?php 

						if($googleApps->edition) {
							echo $googleApps->edition;
						} else {
							echo 'Google Apps';
						}

						?>
					</td>
					<td>
						<?php
						
						$parameters = array();
						$parameters['service'] = 'CPanel';
						$parameters['continue'] = 'https://www.google.com:443/a/cpanel/' . $googleApps->domain->name . '/Dashboard';
						$parameters['passive'] = 'true';
						$parameters['Email'] = $googleApps->adminUsername;

						?>
						<a href="https://www.google.com/a/<?php echo $googleApps->domain->name; ?>/ServiceLogin?<?php echo http_build_query($parameters, '', '&amp;'); ?>" title="Gebruikersnaam: <?php echo $googleApps->adminUsername; ?>@<?php echo $googleApps->domain->name; ?>">
							<?php echo $googleApps->domain->name; ?>
						</a>
					</td>
					<td class="time">
						<?php echo $googleApps->getCreated()->format('d-m-Y H:i'); ?>
					</td>
					<td>
						<?php if($googleApps->mxRecords): ?>
						MX
						<?php endif; ?>
					</td>
					<td>
						<?php if($googleApps->spfRecord): ?>
						SPF
						<?php endif; ?>
					</td>
					<td>
						<a href="http://mail.<?php echo $domain->name; ?>/">
							<img src="/styles/icons/Google-gMail.ico" alt="Google Mail" width="16" height="16" />
						</a>
					</td>
					<td>
						<a href="http://calendar.<?php echo $domain->name; ?>/">
							<img src="/styles/icons/Google-Calendar.ico" alt="Google Calendar" width="16" height="16" />
						</a>
					</td>
					<td>
						<a href="http://docs.<?php echo $domain->name; ?>/">
							<img src="/styles/icons/Google-Docseb.ico" alt="Google Docs" width="16" height="16" />
						</a>
					</td>
					<td>
						<a href="http://sites.<?php echo $domain->name; ?>/">
							<img src="/styles/icons/Google-Sites.ico" alt="Google Sites" width="16" height="16" />
						</a>
					</td>

					<?php else: ?>

					<td colspan="9"></td>

					<?php endif; ?>

					<td>
						<?php if($domain->googleWebmasterTools): ?>

						<?php

						$parameters = array();
						$parameters['siteUrl'] = 'http://' . $domain->name . '/';

						?>

						<a href="https://www.google.com/webmasters/tools/dashboard?<?php echo http_build_query($parameters, '', '&amp;'); ?>">
							<img src="/styles/icons/Google-Webmaster.ico" alt="Google Webmaster" width="16" height="16" />
						</a>

						<?php endif; ?>
					</td>

					<td class="ga-tracking-code">
						<?php if($googleAnalytics = $domain->googleAnalytics): ?>

						<?php

						$parameters = array();
						$parameters['id'] = $googleAnalytics->id;

						?>

						<input class="ga-tracking-code-field" name="domains[<?php echo $domain->id; ?>][ga-tracking-code]" value="<?php echo $googleAnalytics->trackingCode; ?>" type="hidden" />

						<a href="https://www.google.com/analytics/reporting/?<?php echo http_build_query($parameters, '', '&amp;'); ?>">
							<?php echo $googleAnalytics->trackingCode; ?>
						</a>

						<?php endif; ?>
					</td>

					<td class="price">
						<?php if($price = $domain->orbisPrice): ?>

						<a href="http://orbis.<?php echo $domain->name; ?>/">
							&euro; <?php e