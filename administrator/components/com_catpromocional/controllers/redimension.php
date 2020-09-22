<?php
defined('_JEXEC') or die;

ini_set('memory_limit','800M');
ini_set('max_execution_time', 7000);
ini_set('display_startup_errors',1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class  CatPromocionalControllerRedimension extends JControllerLegacy {
	//////////////////////////////////////////////////////////////////
	// Constantes de clase.
	//////////////////////////////////////////////////////////////////
	const RUT_IMAGEN = '/images/catalog/products/';
	const RUT_IMDEST = '/images/catalog/products/temporal/';
	const RUT_IMREAL = '/images/catalog/products/slider/';
	const RUT_IMTHUM = '/images/catalog/products/thumbnails/';	
	// Quality Image.
	const CAL_IMAGEN = 95;	
	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - set Image Dimensions
	//////////////////////////////////////////////////////////////////
	private function setImageDimensions($rutImage,$heiImage,$widImage) {
		// inicializo array medidas.
		$medidas = array();
		// Ancho y alto de la imagen original
		list($ancho,$alto)=getimagesize($rutImage);
		// Asigno medidas reales al array.
		$medidas['ancho'] = $ancho;
		$medidas['alto'] = $alto;
		//Se calcula ancho y alto de la imagen final
		$x_ratio = $widImage / $ancho;
		$y_ratio = $heiImage / $alto;
		//Si el ancho y el alto de la imagen no superan los maximos,
		//ancho final y alto final son los que tiene actualmente
		if( ($ancho <= $widImage) && ($alto <= $heiImage) ){//Si ancho
			$medidas['ancho_final'] = $ancho;
			$medidas['alto_final']  = $alto;
		}
		/*
		* si proporcion horizontal*alto mayor que el alto maximo,
		* alto final es alto por la proporcion horizontal
		* es decir, le quitamos al ancho, la misma proporcion que
		* le quitamos al alto
		*
		*/
		elseif (($x_ratio * $alto) < $heiImage){
			$medidas['alto_final']  = ceil($x_ratio * $alto);
			$medidas['ancho_final'] = $widImage;
		}
		/*
		* Igual que antes pero a la inversa
		*/
		else{
			$medidas['ancho_final'] = ceil($y_ratio * $ancho);
			$medidas['alto_final']  = $heiImage;
		}
		// retorno array con medidas.
		return $medidas;
	}
	
	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - image Redimension
	//////////////////////////////////////////////////////////////////
	private function imageRedimension($namImage,$rutDestin,$heiImage,$widImage) {
		//echo "<br /> Los datos son: ".$namImage."-".$rutDestin."-".$heiImage."-".$widImage;
		// Creamos ruta imagen original.
		$rutImage = JPATH_ROOT.self::RUT_IMAGEN.$namImage;
		// Creamos una variable imagen a partir de la imagen original
		$img_original = imagecreatefromjpeg($rutImage);
		// Definimos las medidas de la nueva imagen.
		$medidas = $this->setImageDimensions($rutImage,$heiImage,$widImage);
		//Creamos una imagen en blanco de tamaño $ancho_final  por $alto_final .
		$tmp=imagecreatetruecolor($medidas['ancho_final'],$medidas['alto_final']);
		//Copiamos $img_original sobre la imagen que acabamos de crear en blanco ($tmp)
		imagecopyresampled(
			$tmp, $img_original, 0, 0, 0, 0,
			$medidas['ancho_final'], $medidas['alto_final'],
			$medidas['ancho'], $medidas['alto']
		);		 
		//Se destruye variable $img_original para liberar memoria
		imagedestroy($img_original);
		//Se crea la imagen final en el directorio indicado
		imagejpeg($tmp, $rutDestin, self::CAL_IMAGEN);
	}
	
	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - fusion Image
	//////////////////////////////////////////////////////////////////
	private function fusionImage($namImage,$ancImagen,$altImagen,$ancFinal,$altFinal,$pthFinal) {
		// Obtengo la ruta destino.
		$rutDestin = JPATH_ROOT.self::RUT_IMDEST.$namImage;
		// creo imagen redimensionada.
		$this->imageRedimension($namImage,$rutDestin,$ancImagen,$altImagen);
		// Creo imagen de Fondo.
		$fondo = imagecreatetruecolor($ancFinal,$altFinal);
		$white = imagecolorallocate($fondo, 255, 255, 255);
		imagefill($fondo, 0, 0, $white);		
		$imagen = imagecreatefromjpeg($rutDestin);
		// Obtengo tamaño
		$size   = getimagesize($rutDestin);
		// Determino posicion sobre la cual se pondrá la imagen.
		$posx = ($ancFinal - $size[0])/2;
		$posy = ($altFinal - $size[1])/2;
		//echo "<br />ancho-".$ancFinal."-alto-".$altFinal."-nancho-".$size[0]."-nalto-".$size[1]."-X-".$posx."-Y-".$posy; exit;
		// Copia y fusiona las imágenes
		imagecopymerge(
			$fondo,   // Imagen Fondo
			$imagen,  // Imagen a superponer
			$posx,    // Posición en X de la imagen
			$posy,    // Posición en Y de la imagen
			0,        // Posición X de imagen
			0,        // Posición Y de imagen
			$size[0], // Ancho imagen a superponer
			$size[1], // Alto imagen a superponer
			100       // Transparencia fondo
		);
		// Output
		header('Content-Type: image/jpeg');
		imagejpeg($fondo, JPATH_ROOT.$pthFinal.$namImage, self::CAL_IMAGEN);
		// Libero memoria.
		imagedestroy($fondo); 
		imagedestroy($imagen);
		// Borrar imagen redimensionada sin fondo.
		@unlink($rutDestin);
	}
	
	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - resize Images Products
	//////////////////////////////////////////////////////////////////
	public function resizeImagesProducts() {
		// set Sizes.
		$ancImagen = 330;
		$altImagen = 345;
		$ancFinal  = 340;
		$altFinal  = 360;
		$cont      = 1;
		//echo "<br />el jpath es: ".JPATH_ROOT.self::RUT_IMAGEN;
		$handle = opendir(JPATH_ROOT.self::RUT_IMAGEN);
		if ($handle) {
            while (false !== ($file = readdir($handle))) {
				//echo "<br />el file es: ".$file;
            	if ($cont <= 200) {
					if (is_dir(JPATH_ROOT.self::RUT_IMAGEN.$file) === false 
						&& file_exists(JPATH_ROOT.self::RUT_IMREAL.$file) !== true) {
						$this->fusionImage($file,$ancImagen,$altImagen,$ancFinal,$altFinal,self::RUT_IMREAL);
						$cont++;
						echo "<br />Se creó la imagen ".JPATH_ROOT.self::RUT_IMAGEN.$file;
					}
				} else {
					break;
				}
			}
			closedir($handle);
		}
		// Redirect To Images.
		$this->redirectToImages('Slide');
	}

	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - generate Thumbnails Products
	//////////////////////////////////////////////////////////////////
	public function generateThumbnailsProducts() {
		// set Sizes.
		$ancImagen = 110;
		$altImagen = 100;
		$ancFinal  = 120;
		$altFinal  = 105;
		$cont      = 1;
		//echo "el jpath es: ".JPATH_ROOT.self::RUT_IMAGEN;exit;
		$handle = opendir(JPATH_ROOT.self::RUT_IMAGEN);
		if ($handle) {
            while (false !== ($file = readdir($handle))) {
            	if ($cont <= 200) {
					if (is_dir(JPATH_ROOT.self::RUT_IMAGEN.$file) === false 
						&& file_exists(JPATH_ROOT.self::RUT_IMTHUM.$file) !== true) {
						$this->fusionImage($file,$ancImagen,$altImagen,$ancFinal,$altFinal,self::RUT_IMTHUM);
						$cont++;
						//echo "<br />Se creo imagen ".JPATH_ROOT.self::RUT_IMTHUM.$file;
					}
					else {
						//echo "<br />Ya existe imagen ".JPATH_ROOT.self::RUT_IMTHUM.$file;
					}
				} else {
					break;
				}
			}
			//exit;
			closedir($handle);
		}
		// Redirect To Images.
		$this->redirectToImages('Thumbnails');
	}
	
	//////////////////////////////////////////////////////////////////
	// 11/04/2016 - redirect To Images
	//////////////////////////////////////////////////////////////////
	private function redirectToImages($typeImages) {
		$app = JFactory::getApplication(); 
		$link = 'index.php?option=com_catpromocional&view=catcarcimagen&layout=edit'; 
		$msg = '<br /> Imágenes '.$typeImages.' generadas correctamente.'; 
		$app->redirect($link, $msg, $msgType='message');		
	}
}
?>