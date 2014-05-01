<?
//header("Content-type: application/xml");

header("Content-Type: application/rss+xml");

require_once('mysql_cfg.php');
require_once('create_thumbnail.php');

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss">
<channel>

<title/>
<link/>
<description/>';


$query = 'SELECT * FROM mapping_files WHERE NAME LIKE "%.jpg" AND filetype LIKE "image%" ORDER BY datum DESC LIMIT 150;';
$data = mysql_query($query);
while ($row = mysql_fetch_array($data))
{
	$thumbpath = $row['file'].'bigthumb';
	$thumbpath = str_replace("uploads/","thumbs/",$thumbpath);				
	if (!file_exists($thumbpath))
	{
		createthumb($row['file'], $thumbpath, 100, 100);
	}
	
	echo '
	<item>
		<title>'.$row['name'].'</title>
		<link>download.php?id='.$row['id'].'</link>
		<media:thumbnail url="'.$thumbpath.'"/>
		<media:content url="download'.$row['id'].'.jpg"/>
	</item>';
}      
echo '    
	
                    
</channel>
</rss>';
/*
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss">
<channel>

<title/>
<link/>
<description/>
	<item>
		<title>BTNWhirlwind.jpg</title>
		<link>download.php?id=174</link>
		<media:thumbnail url="uploads/e9935112da7267fde87733750c33ab60BTNWhirlwind.jpgthumb"/>
		<media:content url="uploads/e9935112da7267fde87733750c33ab60BTNWhirlwind.jpg"/>
	</item>
	<item>
		<title>BTNFrenzy.jpg</title>
		<link>download.php?id=175</link>
		<media:thumbnail url="uploads/edb244910c2c8c40481020eaa53da0b5BTNFrenzy.jpgthumb"/>
		<media:content url="uploads/edb244910c2c8c40481020eaa53da0b5BTNFrenzy.jpg"/>
	</item>
	<item>
		<title>PASBTNSwordMaster.jpg</title>
		<link>download.php?id=176</link>
		<media:thumbnail url="uploads/37f130568fcae948a7841d2a70f5e7e4PASBTNSwordMaster.jpgthumb"/>
		<media:content url="uploads/37f130568fcae948a7841d2a70f5e7e4PASBTNSwordMaster.jpg"/>
	</item>
	<item>
		<title>BTNMindBreaker.jpg</title>
		<link>download.php?id=177</link>
		<media:thumbnail url="uploads/969d55c4023995e2208d0622b5ac8b51BTNMindBreaker.jpgthumb"/>
		<media:content url="uploads/969d55c4023995e2208d0622b5ac8b51BTNMindBreaker.jpg"/>
	</item>
	<item>
		<title>BTNLittleThunderstorm.jpg</title>
		<link>download.php?id=178</link>
		<media:thumbnail url="uploads/ae2c4f3029cb4d8ec87dbc188afdc1c9BTNLittleThunderstorm.jpgthumb"/>
		<media:content url="uploads/ae2c4f3029cb4d8ec87dbc188afdc1c9BTNLittleThunderstorm.jpg"/>
	</item>
	<item>
		<title>BTNBondOfSouls.jpg</title>
		<link>download.php?id=180</link>
		<media:thumbnail url="uploads/41d28b9db26017c4e73779bf0a40213eBTNBondOfSouls.jpgthumb"/>
		<media:content url="uploads/41d28b9db26017c4e73779bf0a40213eBTNBondOfSouls.jpg"/>
	</item>
	<item>
		<title>BTNDarkCloud.jpg</title>
		<link>download.php?id=181</link>
		<media:thumbnail url="uploads/0a63a410d9b6483c5f756962adb4a107BTNDarkCloud.jpgthumb"/>
		<media:content url="uploads/0a63a410d9b6483c5f756962adb4a107BTNDarkCloud.jpg"/>
	</item>
	<item>
		<title>BTNGhostTakeOver.jpg</title>
		<link>download.php?id=182</link>
		<media:thumbnail url="uploads/f19926c95af0594e65a5b40129b2339fBTNGhostTakeOver.jpgthumb"/>
		<media:content url="uploads/f19926c95af0594e65a5b40129b2339fBTNGhostTakeOver.jpg"/>
	</item>
	<item>
		<title>BTNPoisonStrike.jpg</title>
		<link>download.php?id=184</link>
		<media:thumbnail url="uploads/6807c3dee3da177115bc1be85e2d3959BTNPoisonStrike.jpgthumb"/>
		<media:content url="uploads/6807c3dee3da177115bc1be85e2d3959BTNPoisonStrike.jpg"/>
	</item>
	<item>
		<title>BTNFleshBomb.jpg</title>
		<link>download.php?id=185</link>
		<media:thumbnail url="uploads/454b69b79db015892152febbf9076241BTNFleshBomb.jpgthumb"/>
		<media:content url="uploads/454b69b79db015892152febbf9076241BTNFleshBomb.jpg"/>
	</item>
	<item>
		<title>PASBTNUtilizationOfRests.jpg</title>
		<link>download.php?id=186</link>
		<media:thumbnail url="uploads/2a38371f85d591f0345447787582b9aePASBTNUtilizationOfRests.jpgthumb"/>
		<media:content url="uploads/2a38371f85d591f0345447787582b9aePASBTNUtilizationOfRests.jpg"/>
	</item>
	<item>
		<title>BTNMetamorphosis.jpg</title>
		<link>download.php?id=187</link>
		<media:thumbnail url="uploads/28389730e88e11eed667c9801cb5c0fcBTNMetamorphosis.jpgthumb"/>
		<media:content url="uploads/28389730e88e11eed667c9801cb5c0fcBTNMetamorphosis.jpg"/>
	</item>
	<item>
		<title>BTNLifeDrain.jpg</title>
		<link>download.php?id=188</link>
		<media:thumbnail url="uploads/22706af6de3d41b1768df7c705d4a176BTNLifeDrain.jpgthumb"/>
		<media:content url="uploads/22706af6de3d41b1768df7c705d4a176BTNLifeDrain.jpg"/>
	</item>
	<item>
		<title>BTNIceBallOn.jpg</title>
		<link>download.php?id=189</link>
		<media:thumbnail url="uploads/287c52c420a759483c5f7d97be8f4f17BTNIceBallOn.jpgthumb"/>
		<media:content url="uploads/287c52c420a759483c5f7d97be8f4f17BTNIceBallOn.jpg"/>
	</item>
	<item>
		<title>BTNManaTheft.jpg</title>
		<link>download.php?id=190</link>
		<media:thumbnail url="uploads/0fcb3619c28ffb1d5f5949e5b83fc445BTNManaTheft.jpgthumb"/>
		<media:content url="uploads/0fcb3619c28ffb1d5f5949e5b83fc445BTNManaTheft.jpg"/>
	</item>
	<item>
		<title>BTNCurseOfTheBloodline.jpg</title>
		<link>download.php?id=191</link>
		<media:thumbnail url="uploads/5258753911987b224a46da84d38a37d4BTNCurseOfTheBloodline.jpgthumb"/>
		<media:content url="uploads/5258753911987b224a46da84d38a37d4BTNCurseOfTheBloodline.jpg"/>
	</item>
	<item>
		<title>BTNNaturalEmbrace.jpg</title>
		<link>download.php?id=192</link>
		<media:thumbnail url="uploads/0d7ea0fdb996e13ba641fb9de09be3b2BTNNaturalEmbrace.jpgthumb"/>
		<media:content url="uploads/0d7ea0fdb996e13ba641fb9de09be3b2BTNNaturalEmbrace.jpg"/>
	</item>
	<item>
		<title>BTNWonderSeeds.jpg</title>
		<link>download.php?id=193</link>
		<media:thumbnail url="uploads/191d2876476608096cdccb706630576fBTNWonderSeeds.jpgthumb"/>
		<media:content url="uploads/191d2876476608096cdccb706630576fBTNWonderSeeds.jpg"/>
	</item>
	<item>
		<title>BTNFertilizer.jpg</title>
		<link>download.php?id=194</link>
		<media:thumbnail url="uploads/eb2f6ee3ca7c0fd6070b9889ce68605fBTNFertilizer.jpgthumb"/>
		<media:content url="uploads/eb2f6ee3ca7c0fd6070b9889ce68605fBTNFertilizer.jpg"/>
	</item>
	<item>
		<title>BTNTonelessMist.jpg</title>
		<link>download.php?id=195</link>
		<media:thumbnail url="uploads/20f8a01db2fc17b03b54f9b352c6fb17BTNTonelessMist.jpgthumb"/>
		<media:content url="uploads/20f8a01db2fc17b03b54f9b352c6fb17BTNTonelessMist.jpg"/>
	</item>
	<item>
		<title>BTNRainOfArrows.jpg</title>
		<link>download.php?id=196</link>
		<media:thumbnail url="uploads/d9a53b7c401056629e3035730d76786eBTNRainOfArrows.jpgthumb"/>
		<media:content url="uploads/d9a53b7c401056629e3035730d76786eBTNRainOfArrows.jpg"/>
	</item>
	<item>
		<title>BTNEasyPrey.jpg</title>
		<link>download.php?id=197</link>
		<media:thumbnail url="uploads/1951caf8110f5afd81f7c2afef4ab848BTNEasyPrey.jpgthumb"/>
		<media:content url="uploads/1951caf8110f5afd81f7c2afef4ab848BTNEasyPrey.jpg"/>
	</item>
	<item>
		<title>BTNStonesThrow.jpg</title>
		<link>download.php?id=198</link>
		<media:thumbnail url="uploads/52591b8808d13e220924497b87cda13eBTNStonesThrow.jpgthumb"/>
		<media:content url="uploads/52591b8808d13e220924497b87cda13eBTNStonesThrow.jpg"/>
	</item>
	<item>
		<title>BTNSpellDisconnection.jpg</title>
		<link>download.php?id=199</link>
		<media:thumbnail url="uploads/43674ab49f0a587139d5e51ff1ea650fBTNSpellDisconnection.jpgthumb"/>
		<media:content url="uploads/43674ab49f0a587139d5e51ff1ea650fBTNSpellDisconnection.jpg"/>
	</item>
	<item>
		<title>BTNCapeOfTheScholar.jpg</title>
		<link>download.php?id=200</link>
		<media:thumbnail url="uploads/3c53dba7818804c6bdcebfe028f6c5b6BTNCapeOfTheScholar.jpgthumb"/>
		<media:content url="uploads/3c53dba7818804c6bdcebfe028f6c5b6BTNCapeOfTheScholar.jpg"/>
	</item>

	<item>
		<title>BTNJeweledDaggerOfGreed.jpg</title>
		<link>download.php?id=201</link>
		<media:thumbnail url="uploads/998eaa9506be03db15f73d599e28535fBTNJeweledDaggerOfGreed.jpgthumb"/>
		<media:content url="uploads/998eaa9506be03db15f73d599e28535fBTNJeweledDaggerOfGreed.jpg"/>
	</item>
	<item>
		<title>BTNHeartStone.jpg</title>
		<link>download.php?id=202</link>
		<media:thumbnail url="uploads/c1706ff5c7512fbd4a2d560a005aefccBTNHeartStone.jpgthumb"/>
		<media:content url="uploads/c1706ff5c7512fbd4a2d560a005aefccBTNHeartStone.jpg"/>
	</item>
	<item>
		<title>BTNSpiderEgg.jpg</title>
		<link>download.php?id=203</link>
		<media:thumbnail url="uploads/d93a5f53146c7c47c2854067b51307d5BTNSpiderEgg.jpgthumb"/>
		<media:content url="uploads/d93a5f53146c7c47c2854067b51307d5BTNSpiderEgg.jpg"/>
	</item>
	<item>
		<title>BTNVolatileManaPotion.jpg</title>
		<link>download.php?id=204</link>
		<media:thumbnail url="uploads/26d51eb089dc1f6cec3451dc6bbb1e19BTNVolatileManaPotion.jpgthumb"/>
		<media:content url="uploads/26d51eb089dc1f6cec3451dc6bbb1e19BTNVolatileManaPotion.jpg"/>
	</item>
	<item>
		<title>BTNMecaPenguin.jpg</title>
		<link>download.php?id=205</link>
		<media:thumbnail url="uploads/cd756b29f2d13224d3b2145ffb5a2c2bBTNMecaPenguin.jpgthumb"/>
		<media:content url="uploads/cd756b29f2d13224d3b2145ffb5a2c2bBTNMecaPenguin.jpg"/>
	</item>
	<item>
		<title>BTNEnergyGap.jpg</title>
		<link>download.php?id=206</link>
		<media:thumbnail url="uploads/e1e0dd4e82deeb055ff91eb5fd32848dBTNEnergyGap.jpgthumb"/>
		<media:content url="uploads/e1e0dd4e82deeb055ff91eb5fd32848dBTNEnergyGap.jpg"/>
	</item>
	<item>
		<title>BTNElixierOfTheGrowth.jpg</title>
		<link>download.php?id=207</link>
		<media:thumbnail url="uploads/0923a8be606fd8a6e98f7766f87c3d6aBTNElixierOfTheGrowth.jpgthumb"/>
		<media:content url="uploads/0923a8be606fd8a6e98f7766f87c3d6aBTNElixierOfTheGrowth.jpg"/>
	</item>
	<item>
		<title>BTNAmuletOfTheGrouping.jpg</title>
		<link>download.php?id=208</link>
		<media:thumbnail url="uploads/e8aa13236ffafdb65cbc98c2285aab80BTNAmuletOfTheGrouping.jpgthumb"/>
		<media:content url="uploads/e8aa13236ffafdb65cbc98c2285aab80BTNAmuletOfTheGrouping.jpg"/>
	</item>
	<item>
		<title>BTNPotionOfTheInconspicuousShape.jpg</title>
		<link>download.php?id=209</link>
		<media:thumbnail url="uploads/f8d86152db25a21a05c91f0350c14fbcBTNPotionOfTheInconspicuousShape.jpgthumb"/>
		<media:content url="uploads/f8d86152db25a21a05c91f0350c14fbcBTNPotionOfTheInconspicuousShape.jpg"/>
	</item>
	<item>
		<title>Witch.jpg</title>
		<link>download.php?id=229</link>
		<media:thumbnail url="uploads/19d56671e3eebe6af2b7ad8c22419aeaWitch.jpgthumb"/>
		<media:content url="uploads/19d56671e3eebe6af2b7ad8c22419aeaWitch.jpg"/>
	</item>
	<item>
		<title>Botanist.jpg</title>
		<link>download.php?id=213</link>
		<media:thumbnail url="uploads/b3e1ba7b7fc5759d2419c232eb21260fBotanist.jpgthumb"/>
		<media:content url="uploads/b3e1ba7b7fc5759d2419c232eb21260fBotanist.jpg"/>
	</item>
	<item>
		<title>Lich.jpg</title>
		<link>download.php?id=214</link>
		<media:thumbnail url="uploads/f889b878ed9e2ffeae4af1d970e615b1Lich.jpgthumb"/>
		<media:content url="uploads/f889b878ed9e2ffeae4af1d970e615b1Lich.jpg"/>
	</item>
	<item>
		<title>Paladin.jpg</title>
		<link>download.php?id=215</link>
		<media:thumbnail url="uploads/e20ed3f3d6e56df4b31d5aee3b25f3abPaladin.jpgthumb"/>
		<media:content url="uploads/e20ed3f3d6e56df4b31d5aee3b25f3abPaladin.jpg"/>
	</item>
	<item>
		<title>TravellingTrader.jpg</title>
		<link>download.php?id=232</link>
		<media:thumbnail url="uploads/ccbd1ba2884495a821e35538ade7b05cTravellingTrader.jpgthumb"/>
		<media:content url="uploads/ccbd1ba2884495a821e35538ade7b05cTravellingTrader.jpg"/>
	</item>
	<item>
		<title>NamelessOne.jpg</title>
		<link>download.php?id=217</link>
		<media:thumbnail url="uploads/c969e7091d93f19a4c49c5f19cb000f3NamelessOne.jpgthumb"/>
		<media:content url="uploads/c969e7091d93f19a4c49c5f19cb000f3NamelessOne.jpg"/>
	</item>
	<item>
		<title>MedicineMan.jpg</title>
		<link>download.php?id=218</link>
		<media:thumbnail url="uploads/dae9afea3ece9c8dc004c6fa628226d1MedicineMan.jpgthumb"/>
		<media:content url="uploads/dae9afea3ece9c8dc004c6fa628226d1MedicineMan.jpg"/>
	</item>
	<item>
		<title>Headhuntress.jpg</title>
		<link>download.php?id=219</link>
		<media:thumbnail url="uploads/13e330876e3d31b4fed42a43b88d6d2fHeadhuntress.jpgthumb"/>
		<media:content url="uploads/13e330876e3d31b4fed42a43b88d6d2fHeadhuntress.jpg"/>
	</item>
	<item>
		<title>FootyLine.jpg</title>
		<link>download.php?id=227</link>
		<media:thumbnail url="uploads/37dc76245f3b84753ed1eddcbe91f0e2FootyLine.jpgthumb"/>
		<media:content url="uploads/37dc76245f3b84753ed1eddcbe91f0e2FootyLine.jpg"/>
	</item>
	<item>
		<title>SoldiersGroupDojoTheMojoIceTrollPriestOgreBrat.jpg</title>
		<link>download.php?id=222</link>
		<media:thumbnail url="uploads/c42484c5238effecd71463d9dd26d3f0SoldiersGroupDojoTheMojoIceTrollPriestOgreBrat.jpgthumb"/>
		<media:content url="uploads/c42484c5238effecd71463d9dd26d3f0SoldiersGroupDojoTheMojoIceTrollPriestOgreBrat.jpg"/>
	</item>
	<item>
		<title>PASBTNBash.jpg</title>
		<link>download.php?id=223</link>
		<media:thumbnail url="uploads/7ef627c1b69afff0fddbf0fe29a065ffPASBTNBash.jpgthumb"/>
		<media:content url="uploads/7ef627c1b69afff0fddbf0fe29a065ffPASBTNBash.jpg"/>
	</item>
	<item>
		<title>BTNDiversionaryTactics.jpg</title>
		<link>download.php?id=224</link>
		<media:thumbnail url="uploads/afc1e199065e915172ee10948c67ceadBTNDiversionaryTactics.jpgthumb"/>
		<media:content url="uploads/afc1e199065e915172ee10948c67ceadBTNDiversionaryTactics.jpg"/>
	</item>
	<item>
		<title>BTNHealOn.jpg</title>
		<link>download.php?id=225</link>
		<media:thumbnail url="uploads/040e7bc43e4acf15965af522af06a621BTNHealOn.jpgthumb"/>
		<media:content url="uploads/040e7bc43e4acf15965af522af06a621BTNHealOn.jpg"/>
	</item>
	<item>
		<title>Berserker.jpg</title>
		<link>download.php?id=230</link>
		<media:thumbnail url="uploads/84c77d6bcb0f1adaeeb96b658f3683baBerserker.jpgthumb"/>
		<media:content url="uploads/84c77d6bcb0f1adaeeb96b658f3683baBerserker.jpg"/>
	</item>
	<item>
		<title>BrunnenVergiften.jpg</title>
		<link>download.php?id=234</link>
		<media:thumbnail url="uploads/c26f1a7b3d596d93f25de2bcaf11d0b8BrunnenVergiften.jpgthumb"/>
		<media:content url="uploads/c26f1a7b3d596d93f25de2bcaf11d0b8BrunnenVergiften.jpg"/>
	</item>
	<item>
		<title>Faust.jpg</title>
		<link>download.php?id=235</link>
		<media:thumbnail url="uploads/9a05d5c0f683a2f24bf38159ea34ca89Faust.jpgthumb"/>
		<media:content url="uploads/9a05d5c0f683a2f24bf38159ea34ca89Faust.jpg"/>
	</item>
	<item>
		<title>Technician.jpg</title>
		<link>download.php?id=291</link>
		<media:thumbnail url="uploads/fd8d662365033a55d7e90e7e970f8367Technician.jpgthumb"/>
		<media:content url="uploads/fd8d662365033a55d7e90e7e970f8367Technician.jpg"/>
	</item>
	<item>
		<title>PASBTNSystemOptimization.jpg</title>
		<link>download.php?id=296</link>
		<media:thumbnail url="uploads/0e65515066ae102d6c079b170fd455c6PASBTNSystemOptimization.jpgthumb"/>
		<media:content url="uploads/0e65515066ae102d6c079b170fd455c6PASBTNSystemOptimization.jpg"/>
	</item>
	<item>
		<title>terrain3.jpg</title>
		<link>download.php?id=710</link>
		<media:thumbnail url="uploads/7a8f9247b5e98eb0d5a0caee60850493terrain3.jpgthumb"/>
		<media:content url="uploads/7a8f9247b5e98eb0d5a0caee60850493terrain3.jpg"/>
	</item>
	<item>
		<title>BTNIntimidatingView.jpg</title>
		<link>download.php?id=297</link>
		<media:thumbnail url="uploads/3cd42e0598a56c1467677b3b1eb01a4eBTNIntimidatingView.jpgthumb"/>
		<media:content url="uploads/3cd42e0598a56c1467677b3b1eb01a4eBTNIntimidatingView.jpg"/>
	</item>

	<item>
		<title>BTNBattleGolem.jpg</title>
		<link>download.php?id=294</link>
		<media:thumbnail url="uploads/c73f3ddfc5b5af5caa91105938db2d09BTNBattleGolem.jpgthumb"/>
		<media:content url="uploads/c73f3ddfc5b5af5caa91105938db2d09BTNBattleGolem.jpg"/>
	</item>
	<item>
		<title>SnakeQueen.jpg</title>
		<link>download.php?id=292</link>
		<media:thumbnail url="uploads/f4be5e3bb1a7222b18995c3760cc9b8dSnakeQueen.jpgthumb"/>
		<media:content url="uploads/f4be5e3bb1a7222b18995c3760cc9b8dSnakeQueen.jpg"/>
	</item>
	<item>
		<title>BTNBlastFurnace.jpg</title>
		<link>download.php?id=293</link>
		<media:thumbnail url="uploads/d848654be32290978329857ef619f702BTNBlastFurnace.jpgthumb"/>
		<media:content url="uploads/d848654be32290978329857ef619f702BTNBlastFurnace.jpg"/>
	</item>
	<item>
		<title>BTNFirework.jpg</title>
		<link>download.php?id=295</link>
		<media:thumbnail url="uploads/e7a9076ff12876ef390219d2b08e7bfaBTNFirework.jpgthumb"/>
		<media:content url="uploads/e7a9076ff12876ef390219d2b08e7bfaBTNFirework.jpg"/>
	</item>
	<item>
		<title>objectmerger.JPG</title>
		<link>download.php?id=285</link>
		<media:thumbnail url="uploads/80701fc082daffcad34dfc0165ffde40objectmerger.JPGthumb"/>
		<media:content url="uploads/80701fc082daffcad34dfc0165ffde40objectmerger.JPG"/>
	</item>
	<item>
		<title>konf.jpg</title>
		<link>download.php?id=288</link>
		<media:thumbnail url="uploads/fff5c6359baf84cefacad68d929010a6konf.jpgthumb"/>
		<media:content url="uploads/fff5c6359baf84cefacad68d929010a6konf.jpg"/>
	</item>
	<item>
		<title>PASBTNAspectOfTheViper.jpg</title>
		<link>download.php?id=299</link>
		<media:thumbnail url="uploads/25f97e233ea09d5aa6e67b6f9b3fc854PASBTNAspectOfTheViper.jpgthumb"/>
		<media:content url="uploads/25f97e233ea09d5aa6e67b6f9b3fc854PASBTNAspectOfTheViper.jpg"/>
	</item>
	<item>
		<title>BTNSearchForFood.jpg</title>
		<link>download.php?id=300</link>
		<media:thumbnail url="uploads/211334a6cb65a62f50a486fe5fadb621BTNSearchForFood.jpgthumb"/>
		<media:content url="uploads/211334a6cb65a62f50a486fe5fadb621BTNSearchForFood.jpg"/>
	</item>
	<item>
		<title>Screenshot2.jpg</title>
		<link>download.php?id=394</link>
		<media:thumbnail url="uploads/e552ff160404c44c0a2b44d1cda35c0fScreenshot2.jpgthumb"/>
		<media:content url="uploads/e552ff160404c44c0a2b44d1cda35c0fScreenshot2.jpg"/>
	</item>
	<item>
		<title>Earth.jpg</title>
		<link>download.php?id=363</link>
		<media:thumbnail url="uploads/8f1ee73d1bd697b37d15a09115a1313eEarth.jpgthumb"/>
		<media:content url="uploads/8f1ee73d1bd697b37d15a09115a1313eEarth.jpg"/>
	</item>
	<item>
		<title>Brick.jpg</title>
		<link>download.php?id=364</link>
		<media:thumbnail url="uploads/d0922b6438eae3410939aefd2408b033Brick.jpgthumb"/>
		<media:content url="uploads/d0922b6438eae3410939aefd2408b033Brick.jpg"/>
	</item>
	<item>
		<title>Grass.jpg</title>
		<link>download.php?id=365</link>
		<media:thumbnail url="uploads/b2eb7bc0d888d8273755964ad2968d80Grass.jpgthumb"/>
		<media:content url="uploads/b2eb7bc0d888d8273755964ad2968d80Grass.jpg"/>
	</item>
	<item>
		<title>Marble.jpg</title>
		<link>download.php?id=366</link>
		<media:thumbnail url="uploads/df1cc35af0665a31a84a265998602ac2Marble.jpgthumb"/>
		<media:content url="uploads/df1cc35af0665a31a84a265998602ac2Marble.jpg"/>
	</item>
	<item>
		<title>Solid.jpg</title>
		<link>download.php?id=367</link>
		<media:thumbnail url="uploads/d4f3d21d9d2c8995988b4e5bdcf5c7afSolid.jpgthumb"/>
		<media:content url="uploads/d4f3d21d9d2c8995988b4e5bdcf5c7afSolid.jpg"/>
	</item>
	<item>
		<title>FootyOverview.jpg</title>
		<link>download.php?id=370</link>
		<media:thumbnail url="uploads/847d1f822ad3dab34e23c11363bc6dcaFootyOverview.jpgthumb"/>
		<media:content url="uploads/847d1f822ad3dab34e23c11363bc6dcaFootyOverview.jpg"/>
	</item>
	<item>
		<title>Minimap.jpg</title>
		<link>download.php?id=371</link>
		<media:thumbnail url="uploads/9e30bc034e240a25bd405b41fbb482bdMinimap.jpgthumb"/>
		<media:content url="uploads/9e30bc034e240a25bd405b41fbb482bdMinimap.jpg"/>
	</item>
	<item>
		<title>Flag.jpg</title>
		<link>download.php?id=372</link>
		<media:thumbnail url="uploads/4883d54370699b08ed81464e1f771905Flag.jpgthumb"/>
		<media:content url="uploads/4883d54370699b08ed81464e1f771905Flag.jpg"/>
	</item>
	<item>
		<title>Screenshot1.jpg</title>
		<link>download.php?id=384</link>
		<media:thumbnail url="uploads/49cea8d3ff61d6b0e01380a621548b20Screenshot1.jpgthumb"/>
		<media:content url="uploads/49cea8d3ff61d6b0e01380a621548b20Screenshot1.jpg"/>
	</item>
	<item>
		<title>Screenshot3.jpg</title>
		<link>download.php?id=385</link>
		<media:thumbnail url="uploads/489afe2cc878b716c889a74d8dcec097Screenshot3.jpgthumb"/>
		<media:content url="uploads/489afe2cc878b716c889a74d8dcec097Screenshot3.jpg"/>
	</item>
	<item>
		<title>Screenshot4.jpg</title>
		<link>download.php?id=386</link>
		<media:thumbnail url="uploads/38288e044c959c6921a01d963d73545cScreenshot4.jpgthumb"/>
		<media:content url="uploads/38288e044c959c6921a01d963d73545cScreenshot4.jpg"/>
	</item>
	<item>
		<title>Screenshot5.jpg</title>
		<link>download.php?id=387</link>
		<media:thumbnail url="uploads/8a0a3ece293753fa40b09b83be9b8055Screenshot5.jpgthumb"/>
		<media:content url="uploads/8a0a3ece293753fa40b09b83be9b8055Screenshot5.jpg"/>
	</item>
	<item>
		<title>Screenshot6.jpg</title>
		<link>download.php?id=388</link>
		<media:thumbnail url="uploads/399955d5743ca3c3952d79495cea13d1Screenshot6.jpgthumb"/>
		<media:content url="uploads/399955d5743ca3c3952d79495cea13d1Screenshot6.jpg"/>
	</item>
	<item>
		<title>Screenshot7.jpg</title>
		<link>download.php?id=389</link>
		<media:thumbnail url="uploads/6e37db91761c5c7f309e23767d624292Screenshot7.jpgthumb"/>
		<media:content url="uploads/6e37db91761c5c7f309e23767d624292Screenshot7.jpg"/>
	</item>
	<item>
		<title>IceDesert.jpg</title>
		<link>download.php?id=390</link>
		<media:thumbnail url="uploads/34d3be8438f17aeb058bb912f1df2a33IceDesert.jpgthumb"/>
		<media:content url="uploads/34d3be8438f17aeb058bb912f1df2a33IceDesert.jpg"/>
	</item>
	<item>
		<title>IceDesert2.jpg</title>
		<link>download.php?id=391</link>
		<media:thumbnail url="uploads/a5fe68eb091b013a93434db454775d1aIceDesert2.jpgthumb"/>
		<media:content url="uploads/a5fe68eb091b013a93434db454775d1aIceDesert2.jpg"/>
	</item>
	<item>
		<title>IceDesert3.jpg</title>
		<link>download.php?id=392</link>
		<media:thumbnail url="uploads/eac98203e215cab5224475822c057b22IceDesert3.jpgthumb"/>
		<media:content url="uploads/eac98203e215cab5224475822c057b22IceDesert3.jpg"/>
	</item>
	<item>
		<title>IceDesert4.jpg</title>
		<link>download.php?id=393</link>
		<media:thumbnail url="uploads/0598f7d62852a77a9831a1f9dc562215IceDesert4.jpgthumb"/>
		<media:content url="uploads/0598f7d62852a77a9831a1f9dc562215IceDesert4.jpg"/>
	</item>
	<item>
		<title>opfer2.jpg</title>
		<link>download.php?id=677</link>
		<media:thumbnail url="uploads/f2a14cfd936c7f7f0819787feb1e4767opfer2.jpgthumb"/>
		<media:content url="uploads/f2a14cfd936c7f7f0819787feb1e4767opfer2.jpg"/>
	</item>
	<item>
		<title>EventAbilities.jpg</title>
		<link>download.php?id=405</link>
		<media:thumbnail url="uploads/5afbf46383656cf804f460a9aa45be82EventAbilities.jpgthumb"/>
		<media:content url="uploads/5afbf46383656cf804f460a9aa45be82EventAbilities.jpg"/>
	</item>
	<item>
		<title>BTNDojo.jpg</title>
		<link>download.php?id=619</link>
		<media:thumbnail url="uploads/61456ebe7daa9aa9945d5223b9f3c56eBTNDojo.jpgthumb"/>
		<media:content url="uploads/61456ebe7daa9aa9945d5223b9f3c56eBTNDojo.jpg"/>
	</item>

	<item>
		<title>BTNIceTrollPriest.jpg</title>
		<link>download.php?id=620</link>
		<media:thumbnail url="uploads/890d82a86bd1ba12b148867e9a54e3a4BTNIceTrollPriest.jpgthumb"/>
		<media:content url="uploads/890d82a86bd1ba12b148867e9a54e3a4BTNIceTrollPriest.jpg"/>
	</item>
	<item>
		<title>BTNOgre.jpg</title>
		<link>download.php?id=621</link>
		<media:thumbnail url="uploads/ed51740672761bd840ea6b58d0398ce3BTNOgre.jpgthumb"/>
		<media:content url="uploads/ed51740672761bd840ea6b58d0398ce3BTNOgre.jpg"/>
	</item>
	<item>
		<title>terrain2.jpg</title>
		<link>download.php?id=707</link>
		<media:thumbnail url="uploads/da983100ffa27663dbb9cac130975b2eterrain2.jpgthumb"/>
		<media:content url="uploads/da983100ffa27663dbb9cac130975b2eterrain2.jpg"/>
	</item>
	<item>
		<title>terrain.jpg</title>
		<link>download.php?id=708</link>
		<media:thumbnail url="uploads/bfc1c1abe259dec037e532dfb826fcf5terrain.jpgthumb"/>
		<media:content url="uploads/bfc1c1abe259dec037e532dfb826fcf5terrain.jpg"/>
	</item>
	<item>
		<title>lol2.jpg</title>
		<link>download.php?id=709</link>
		<media:thumbnail url="uploads/a06837508c7bd30cbe3f2afcd1754045lol2.jpgthumb"/>
		<media:content url="uploads/a06837508c7bd30cbe3f2afcd1754045lol2.jpg"/>
	</item>
	<item>
		<title>Insel2.jpg</title>
		<link>download.php?id=705</link>
		<media:thumbnail url="uploads/d8af7c7efff0dbd30ad82ddaf2bedfcaInsel2.jpgthumb"/>
		<media:content url="uploads/d8af7c7efff0dbd30ad82ddaf2bedfcaInsel2.jpg"/>
	</item>
	<item>
		<title>terrain.jpg</title>
		<link>download.php?id=703</link>
		<media:thumbnail url="uploads/11c347c979ed21f0f15195cc559c9809terrain.jpgthumb"/>
		<media:content url="uploads/11c347c979ed21f0f15195cc559c9809terrain.jpg"/>
	</item>
	<item>
		<title>Insel.jpg</title>
		<link>download.php?id=704</link>
		<media:thumbnail url="uploads/5700c578fcc68c138e8f099464095ccdInsel.jpgthumb"/>
		<media:content url="uploads/5700c578fcc68c138e8f099464095ccdInsel.jpg"/>
	</item>
	<item>
		<title>BTNDwarves.jpg</title>
		<link>download.php?id=606</link>
		<media:thumbnail url="uploads/a401fc23afbe1551f222faac07fce3f2BTNDwarves.jpgthumb"/>
		<media:content url="uploads/a401fc23afbe1551f222faac07fce3f2BTNDwarves.jpg"/>
	</item>
	<item>
		<title>BTNDiversionShot.jpg</title>
		<link>download.php?id=605</link>
		<media:thumbnail url="uploads/750eba6275f5241a0d0fc4890b312710BTNDiversionShot.jpgthumb"/>
		<media:content url="uploads/750eba6275f5241a0d0fc4890b312710BTNDiversionShot.jpg"/>
	</item>
	<item>
		<title>BTNAdjutant.jpg</title>
		<link>download.php?id=607</link>
		<media:thumbnail url="uploads/95432dd990ac59c38eabdcffad602333BTNAdjutant.jpgthumb"/>
		<media:content url="uploads/95432dd990ac59c38eabdcffad602333BTNAdjutant.jpg"/>
	</item>
	<item>
		<title>BTNEvilGrowl.jpg</title>
		<link>download.php?id=608</link>
		<media:thumbnail url="uploads/aec41ab7caa59a0d2e8dde5e5b9f3132BTNEvilGrowl.jpgthumb"/>
		<media:content url="uploads/aec41ab7caa59a0d2e8dde5e5b9f3132BTNEvilGrowl.jpg"/>
	</item>
	<item>
		<title>BTNTuskar.jpg</title>
		<link>download.php?id=609</link>
		<media:thumbnail url="uploads/a7d0a4026d610e21518be4689e04d05bBTNTuskar.jpgthumb"/>
		<media:content url="uploads/a7d0a4026d610e21518be4689e04d05bBTNTuskar.jpg"/>
	</item>
	<item>
		<title>BTNNet.jpg</title>
		<link>download.php?id=610</link>
		<media:thumbnail url="uploads/2e00a2375e3f6936ad5701514146b82dBTNNet.jpgthumb"/>
		<media:content url="uploads/2e00a2375e3f6936ad5701514146b82dBTNNet.jpg"/>
	</item>
	<item>
		<title>BTNSilverTail.jpg</title>
		<link>download.php?id=611</link>
		<media:thumbnail url="uploads/dc87e1b562fc086b7911951ba01466d3BTNSilverTail.jpgthumb"/>
		<media:content url="uploads/dc87e1b562fc086b7911951ba01466d3BTNSilverTail.jpg"/>
	</item>
	<item>
		<title>BTNSilverSpores.jpg</title>
		<link>download.php?id=612</link>
		<media:thumbnail url="uploads/19d569264e606d7dcebe3a17f94e71a5BTNSilverSpores.jpgthumb"/>
		<media:content url="uploads/19d569264e606d7dcebe3a17f94e71a5BTNSilverSpores.jpg"/>
	</item>
	<item>
		<title>BTNMasterBuilder.jpg</title>
		<link>download.php?id=613</link>
		<media:thumbnail url="uploads/904ce453775567deebc6bc33b2870221BTNMasterBuilder.jpgthumb"/>
		<media:content url="uploads/904ce453775567deebc6bc33b2870221BTNMasterBuilder.jpg"/>
	</item>
	<item>
		<title>BTNWarEngineer.jpg</title>
		<link>download.php?id=614</link>
		<media:thumbnail url="uploads/e906f1e23eef963f7acc5ae1dd2b9c67BTNWarEngineer.jpgthumb"/>
		<media:content url="uploads/e906f1e23eef963f7acc5ae1dd2b9c67BTNWarEngineer.jpg"/>
	</item>
	<item>
		<title>BTNRust.jpg</title>
		<link>download.php?id=615</link>
		<media:thumbnail url="uploads/e873288f40c5f5caaa5dbb65637bfff6BTNRust.jpgthumb"/>
		<media:content url="uploads/e873288f40c5f5caaa5dbb65637bfff6BTNRust.jpg"/>
	</item>
	<item>
		<title>BTNRefillMana.jpg</title>
		<link>download.php?id=616</link>
		<media:thumbnail url="uploads/f2e8513edda8952a4b98971cc0253630BTNRefillMana.jpgthumb"/>
		<media:content url="uploads/f2e8513edda8952a4b98971cc0253630BTNRefillMana.jpg"/>
	</item>
	<item>
		<title>BTNEvade.jpg</title>
		<link>download.php?id=617</link>
		<media:thumbnail url="uploads/e8ed756d4e32feea1f1c7380b10dc75dBTNEvade.jpgthumb"/>
		<media:content url="uploads/e8ed756d4e32feea1f1c7380b10dc75dBTNEvade.jpg"/>
	</item>
	<item>
		<title>BTNWolf.jpg</title>
		<link>download.php?id=618</link>
		<media:thumbnail url="uploads/30414c5dd1e348ad1bd83dc36b28fc36BTNWolf.jpgthumb"/>
		<media:content url="uploads/30414c5dd1e348ad1bd83dc36b28fc36BTNWolf.jpg"/>
	</item>
	<item>
		<title>Insel7.jpg</title>
		<link>download.php?id=719</link>
		<media:thumbnail url="uploads/46c32c3bd4e084b504d6033ca63477f9Insel7.jpgthumb"/>
		<media:content url="uploads/46c32c3bd4e084b504d6033ca63477f9Insel7.jpg"/>
	</item>
	<item>
		<title>wordle.jpg</title>
		<link>download.php?id=721</link>
		<media:thumbnail url="uploads/03342df4df2bba462465ca8af0afd68cwordle.jpgthumb"/>
		<media:content url="uploads/03342df4df2bba462465ca8af0afd68cwordle.jpg"/>
	</item>
	<item>
		<title>terrain5.jpg</title>
		<link>download.php?id=712</link>
		<media:thumbnail url="uploads/85593a5ac6bc0506003b66292d140629terrain5.jpgthumb"/>
		<media:content url="uploads/85593a5ac6bc0506003b66292d140629terrain5.jpg"/>
	</item>
	<item>
		<title>lol4.jpg</title>
		<link>download.php?id=713</link>
		<media:thumbnail url="uploads/7b28821f2b833096b04147c9ec3ad7f6lol4.jpgthumb"/>
		<media:content url="uploads/7b28821f2b833096b04147c9ec3ad7f6lol4.jpg"/>
	</item>
	<item>
		<title>Insel3.jpg</title>
		<link>download.php?id=716</link>
		<media:thumbnail url="uploads/909c4e01af187540dfa87456c9d3eaceInsel3.jpgthumb"/>
		<media:content url="uploads/909c4e01af187540dfa87456c9d3eaceInsel3.jpg"/>
	</item>
	<item>
		<title>Insel4.jpg</title>
		<link>download.php?id=717</link>
		<media:thumbnail url="uploads/30d4840a607f8dd539492b645e286fb5Insel4.jpgthumb"/>
		<media:content url="uploads/30d4840a607f8dd539492b645e286fb5Insel4.jpg"/>
	</item>
	<item>
		<title>Insel6.jpg</title>
		<link>download.php?id=718</link>
		<media:thumbnail url="uploads/6078b90d925883ea58390731d566cbd2Insel6.jpgthumb"/>
		<media:content url="uploads/6078b90d925883ea58390731d566cbd2Insel6.jpg"/>
	</item>
	<item>
		<title>terrain4.jpg</title>
		<link>download.php?id=711</link>
		<media:thumbnail url="uploads/6612eb602b57bfc89eaca82253da797eterrain4.jpgthumb"/>
		<media:content url="uploads/6612eb602b57bfc89eaca82253da797eterrain4.jpg"/>
	</item>
	<item>
		<title>LunchTime.jpg</title>
		<link>download.php?id=732</link>
		<media:thumbnail url="uploads/4f6288af6990f9ea435b5900f0204c74LunchTime.jpgthumb"/>
		<media:content url="uploads/4f6288af6990f9ea435b5900f0204c74LunchTime.jpg"/>
	</item>

	<item>
		<title>Triggers.jpg</title>
		<link>download.php?id=733</link>
		<media:thumbnail url="uploads/42538e6d563d060e356a4ddf2d4cff33Triggers.jpgthumb"/>
		<media:content url="uploads/42538e6d563d060e356a4ddf2d4cff33Triggers.jpg"/>
	</item>
	<item>
		<title>Clipboard01.jpg</title>
		<link>download.php?id=686</link>
		<media:thumbnail url="uploads/54d41573eb6deafc7e00a02c0a4e76e8Clipboard01.jpgthumb"/>
		<media:content url="uploads/54d41573eb6deafc7e00a02c0a4e76e8Clipboard01.jpg"/>
	</item>
	<item>
		<title>Clipboard02.jpg</title>
		<link>download.php?id=687</link>
		<media:thumbnail url="uploads/ba8913d34c05217514092f1ff63d07d4Clipboard02.jpgthumb"/>
		<media:content url="uploads/ba8913d34c05217514092f1ff63d07d4Clipboard02.jpg"/>
	</item>
	<item>
		<title>Clipboard02.jpg</title>
		<link>download.php?id=688</link>
		<media:thumbnail url="uploads/4f745472e67a1fc6f64f62ee16684d6bClipboard02.jpgthumb"/>
		<media:content url="uploads/4f745472e67a1fc6f64f62ee16684d6bClipboard02.jpg"/>
	</item>
	<item>
		<title>Clipboard03.jpg</title>
		<link>download.php?id=689</link>
		<media:thumbnail url="uploads/d4c1adce6e5653fc339a3c70573db5efClipboard03.jpgthumb"/>
		<media:content url="uploads/d4c1adce6e5653fc339a3c70573db5efClipboard03.jpg"/>
	</item> 
	<item>
		<title>dojocw6.jpg</title>
		<link>download.php?id=101</link>
		<media:thumbnail url="uploads/0ba6dfcbd46c4dbe15a5c7af57ba24c8dojocw6.jpgthumb"/>
		<media:content url="uploads/0ba6dfcbd46c4dbe15a5c7af57ba24c8dojocw6.jpg"/>
	</item>

	<item>
		<title>C</title>
		<link>pl_images/C.jpg</link>
		<guid>d45ac14c-f589-4457-9c0d-6bdff596e04d</guid>
		<media:thumbnail url="pl_thumbs/C_thumb.jpg"/>
		<media:content url="pl_images/C.jpg" type=""/>
	</item>

	<item>
		<title>A</title>
		<link>pl_images/A.jpg</link>
		<guid>dc75b142-3a06-44e8-a04a-fe2a9ba084bd</guid>
		<media:thumbnail url="pl_thumbs/A_thumb.jpg"/>
		<media:content url="pl_images/A.jpg" type=""/>
	</item>

	<item>
		<title>B</title>
		<link>pl_images/B.jpg</link>
		<guid>58b08b4c-b1a1-441a-ba90-22e4ec89fc2e</guid>
		<media:thumbnail url="pl_thumbs/B_thumb.jpg"/>
		<media:content url="pl_images/B.jpg" type=""/>
	</item>

</channel>
</rss>';*/
?>
