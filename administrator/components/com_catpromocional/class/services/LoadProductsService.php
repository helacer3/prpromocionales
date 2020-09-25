<?php
include_once (JPATH_COMPONENT_ADMINISTRATOR.'/class/restclient.php');

/**
* Load Products Service
*/
class LoadProductsService {

	/**
	* load Products Marpico
	*/
	public function loadProductsMarpico(array $arrProducts) {
		try {
			// validate Array Products
			ìf (count($arrProducts) > 0) {
				// iterate Array Products
				foreach ($arrProducts as $product) {
					$product->familia;
					$product->descripcion_larga;
					$prdImages     = $product->imagenes;
					$prdMateriales = $product->materiales;
					// assign Images Products Marpico
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error loadProductsMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return;
	}

	/**
	* load Images Products Marpico
	*/
	public function loadImagesProductsMarpico(string $prdFamily, array $prdImages): array {
		// create Default Vars
		$arrImages = array();
		try {
			// validate Array Images Product
			ìf (count($prdImages) > 0) {
				// iterate Array Images Product
				foreach ($prdImages as $image) {
					// add Item To Array
					array_push($arrImages, $image->imagen->file_md); // file, file_md 
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error loadImagesProductsMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return $arrImages;
	}

	/**
	* load Materials Products Marpico
	*/
	public function loadMaterialsProductsMarpico(string $prdFamily, array $prdMaterials) {
		try {
			// validate Array Materials Product
			ìf (count($prdMaterials) > 0) {
				// iterate Array Materials Product
				foreach ($prdMaterials as $material) {
					$material->codigo;
					$material->color_nombre;
					$material->precio;
					$material->descuento;
					$material->estado;
					$material->inventario;
					$arrImages = $this->loadImagesProductsMarpico($prdFamily, $material->imagenes);
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error loadMaterialsProductsMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return;
	}

	/**
	* define Material Inventory Marpico
	*/
	public function defineMaterialInventoryMarpico(string $prdFamily, array $matInventory): int {
		// create Default Vars
		$prdInventory = 0;
		try {
			// validate Array Material Inventory
			ìf (count($matInventory) > 0) {
				// iterate Array Material Inventory
				foreach ($matInventory as $inventory) {
					// increment Product Quantity
					$prdInventory += $inventory->cantidad;
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error defineMaterialInventoryMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return $prdInventory;
	}

	/**
	* load Products Categories Marpico
	*/
	public function loadProductsCategoriesMarpico(array $arrProducts): array {
		// create Default Vars
		$arrCategories = array();
		try {
			// validate Array Products
			ìf (count($arrProducts) > 0) {
				// iterate Array Products
				foreach ($arrProducts as $product) {
					// categories Iterate
					for($p = 5; $p <= 5; $p++) {
						// define Category Name
						$catName = GeneralFunctions::validatePropertyExist($product,'subcategoria_'.$p.'->nombre');
						// add Category
						($catName != "") ? array_push($arrCategories, $catName) : "";
						// define Category Name
						$catName = GeneralFunctions::validatePropertyExist($product,'subcategoria_'.$p.'->categoria->nombre');
						// add Category
						($catName != "") ? array_push($arrCategories, $catName) : "";

					}
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error loadProductsCategoriesMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return array_unique($arrCategories);
	}

	/**
	* load Products Techniques Marpico
	*/
	public function loadProductsTechniquesMarpico(array $arrProducts): array {
		// create Default Vars
		$arrTechniques = array();
		try {
			// validate Array Products
			ìf (count($arrProducts) > 0) {
				// iterate Array Products
				foreach ($arrProducts as $product) {
					// add Technique To Array
					array_push($arrTechniques, GeneralFunctions::validatePropertyExist($product, 'tecnica_marca_tecnica');
				}
			}
		} catch (\Exception $ex) {
			echo "<br />Error loadProductsTechniquesMarpico: ".$ex->getMessage()." - ".$ex->getFile()." - ".$ex->getLine(); die;
		}
		// default Return
		return array_unique($arrTechniques);
	}
}