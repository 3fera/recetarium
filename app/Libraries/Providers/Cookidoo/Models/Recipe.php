<?php

namespace App\Libraries\Providers\Cookidoo\Models;

/**
 * Cookido Provider Recipe Class
 */
class Recipe
{
    public $id;

    public $v1Id;

    public $image;

    public $name;

    public $favCount;

    public $category;

    public $subCategory;

    public $portions;

    public $steps = [];

    public $ingredients = [];

    public $timeTotal;

    public $timeActive;

    public $timeWaiting;

    public $kilojoules;

    public $kilocalories;

    public $protein;

    public $carbohydrates;

    public $fat;

    public $cholesterol;

    public $dietaryFibre;

    public $thermomixes = [];

    public $priceLevel;

    public $difficulty;

    public $info = [];

    private $data;

    /**
     * @param int $recipeId
     * @param string $path Path to Json file
     */
    public function __construct($recipeId, $path)
    {
        $this->id = $recipeId;
        $content = $this->parseChars(file_get_contents($path));
        $this->data = json_decode($content);

        $this->parseData();
    }

    /**
     * Parses and sets the Json data.
     */
    private function parseData()
    {
        $this->name = $this->data->name;
        $this->v1Id = $this->data->v1Id;
        $this->favCount = $this->data->favCount ?: 0;
        $this->portions = $this->data->portion->value;
        $this->difficulty = $this->data->difficulty;
        $this->priceLevel = $this->data->priceLevel;
        $this->category = $this->data->primaryCategory->title;
        $this->subCategory = isset($this->data->primaryCategory->subtitle) ? $this->data->primaryCategory->subtitle : null;

        $this->parseImage();
        $this->parseInformation();
        $this->parseSteps();
        $this->parseIngredients();
        $this->parseNutrition();
        $this->parseTimes();

        $this->data = null;
    }

    /**
     * Parses the image.
     */
    private function parseImage()
    {
        foreach ($this->data->imageSlots as $image) {
            if ($image->name == 'ipad_recipe_quickview') {
                $this->image = $image->url;
            }
        }
    }

    /**
     * Parses the times.
     */
    private function parseTimes()
    {
        if (!isset($this->data->times) || !count($this->data->times)) {
            return;
        }
        foreach ($this->data->times as $time) {
            switch ($time->type) {
                case 'TOTAL_TIME':
                    $this->timeTotal = $time->value;
                break;
                case 'ACTIVE_TIME':
                    $this->timeActive = $time->value;
                break;
                case 'WAITING_TIME':
                    $this->timeWaiting = $time->value;
                break;
            }
        }

        if (!$this->timeWaiting) {
            $this->timeWaiting = $this->timeTotal - $this->timeActive;
        }
        if ($this->timeWaiting < 0) {
            $this->timeWaiting = 0;
        }
    }

    /**
     * Parses and sets the nutrition information
     */
    private function parseNutrition()
    {
        if (!isset($this->data->recipeNutritionGroups)) {
            return;
        }

        foreach ($this->data->recipeNutritionGroups as $group) {
            foreach ($group->recipeNutritions as $nutritionInfo) {
                if (!isset($nutritionInfo->servingSizeUnit) || $nutritionInfo->servingSizeUnit->type != 'UNIT' || !$nutritionInfo->quantity) {
                    continue;
                }
                foreach ($nutritionInfo->nutrition as $info) {
                    $total = round($info->number / $nutritionInfo->quantity, 2);
                    switch ($info->type) {
                        case 'DIETARY_FIBRE':
                            $this->dietaryFibre = $total;
                        break;
                        case 'CHOLESTEROL':
                            $this->cholesterol = $total;
                        break;
                        case 'FAT':
                            $this->fat = $total;
                        break;
                        case 'CARB':
                            $this->carbohydrates = $total;
                        break;
                        case 'PROTEIN':
                            $this->protein = $total;
                        break;
                        case 'K_J':
                            $this->kilojoules = $total;
                        break;
                        case 'KCAL':
                            $this->kilocalories = $total;
                        break;
                    }
                }
            }
        }
    }

    /**
     * Parses and sets the additional information
     */
    private function parseInformation()
    {
        foreach ($this->data->additionalInformations as $info) {
            $this->info[] = strip_tags(preg_replace('/\s+/', ' ', html_entity_decode($info->information)));
        }
    }

    /**
     * Parses and sets the steps.
     */
    private function parseSteps()
    {
        foreach ($this->data->recipeStepGroups as $group) {
            foreach ($group->recipeSteps as $step) {
                $this->steps[$step->number] = strip_tags(html_entity_decode($step->formattedText));
            }
        }
    }

    /**
     * Parses and sets the ingredients
     */
    private function parseIngredients()
    {
        foreach ($this->data->recipeIngredientGroups as $group) {
            foreach ($group->recipeIngredients as $ingredient) {
                $unit = $this->parseIngredientUnit($ingredient);
                $quantity = $this->parseIngredientQuantity($ingredient);
                $preparation = $this->parseIngredientPreparation($ingredient);

                $this->ingredients[] = (object) [
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'name' => isset($ingredient->ingredient->name) ? $ingredient->ingredient->name : null,
                    'shoppingCategories' => $this->parseIngredientShoppingCategories($ingredient),
                    'foodCategories' => $this->parseIngredientFoodCategories($ingredient),
                    'notation' => $ingredient->notation,
                    'preparation' => $preparation,
                    'optional' => $ingredient->optional,
                ];
            }
        }
    }

    private function parseIngredientShoppingCategories($ingredient)
    {
        $categories = [];
        foreach ($ingredient->ingredient->shoppingCategories as $category) {
            if (isset($category->name)) {
                $categories[] = trim($category->name);
            }
        }

        return $categories;
    }

    private function parseIngredientFoodCategories($ingredient)
    {
        $categories = [];
        foreach ($ingredient->ingredient->foodCategories as $category) {
            if (isset($category->name)) {
                $categories[] = trim($category->name);
            }
        }

        return $categories;
    }

    /**
     * Parses the ingredient preparation
     *
     * @param object $ingredient
     *
     * @return string|null
     */
    private function parseIngredientPreparation($ingredient)
    {
        return isset($ingredient->preparation) ? $ingredient->preparation : null;
    }

    /**
     * Parses the ingredient units
     *
     * @param object $ingredient
     *
     * @return string|null
     */
    private function parseIngredientUnit($ingredient)
    {
        $unit = end($ingredient->recipeIngredientUnits);

        return isset($unit->unit->name) ? $unit->unit->name : null ;
    }

    /**
     * Parse the ingredient quantities.
     *
     * @param object $ingredient
     *
     * @return string
     */
    private function parseIngredientQuantity($ingredient)
    {
        $quantity = $ingredient->quantity;
        if (isset($quantity->value)) {
            return $quantity->value;
        }
        if (isset($quantity->from) && isset($quantity->to)) {
            return $quantity->from . '-' . $quantity->to;
        }
    }

    /**
     * Parse the special chars of a step string.
     *
     * @param string $string
     *
     * @return string
     */
    private function parseChars($string)
    {
        $string = str_replace('\ue003', 'Giro inverso', $string);
        $string = str_replace('\ue002', 'Cuchara', $string);
        $string = str_replace('\ue001', 'Amasar', $string);

        return $string;
    }

    /**
     * Store the recipe data into a json file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function store($path)
    {
        return file_put_contents($path . '/' . $this->id . '.json', json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
