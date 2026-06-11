<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed demo categories, brands and products.
     */
    public function run(): void
    {
        $categories = $this->seedCategories();
        $brands = $this->seedBrands();
        $this->seedProducts($categories, $brands);
    }

    /**
     * @return array<string, Category>
     */
    private function seedCategories(): array
    {
        $definitions = [
            'Whey Protein' => 'Premium whey protein powders to support muscle recovery and growth.',
            'Mass Gainers' => 'High-calorie weight gainers for building size and strength.',
            'Pre-Workout' => 'Energy and focus formulas to power your training sessions.',
            'Vitamins & Wellness' => 'Daily vitamins, minerals and wellness supplements for overall health.',
            'Sports Accessories' => 'Shakers, gloves and training accessories for the gym.',
            'Gym Equipment' => 'Home gym equipment to train anywhere, anytime.',
        ];

        $categories = [];
        $sortOrder = 0;

        foreach ($definitions as $name => $description) {
            $categories[$name] = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $description,
                    'is_active' => true,
                    'sort_order' => $sortOrder++,
                ]
            );
        }

        return $categories;
    }

    /**
     * @return array<string, Brand>
     */
    private function seedBrands(): array
    {
        $names = ['Optimum Nutrition', 'MuscleTech', 'BSN', 'Dymatize', 'Ceylon Fit'];

        $brands = [];

        foreach ($names as $name) {
            $brands[$name] = Brand::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'is_active' => true,
                ]
            );
        }

        return $brands;
    }

    /**
     * @param  array<string, Category>  $categories
     * @param  array<string, Brand>  $brands
     */
    private function seedProducts(array $categories, array $brands): void
    {
        $products = [
            [
                'category' => 'Whey Protein',
                'brand' => 'Optimum Nutrition',
                'name' => 'Optimum Nutrition Gold Standard 100% Whey',
                'sku' => 'ON-GSW-1KG',
                'price' => 9500,
                'sale_price' => 8900,
                'stock_quantity' => 50,
                'is_featured' => true,
                'short_description' => "The world's best-selling whey protein powder, packed with 24g of premium whey in every scoop.",
                'description' => "Optimum Nutrition's Gold Standard 100% Whey is a blend of whey protein isolates, concentrate and peptides, delivering 24g of protein, 5.5g of BCAAs and 4g of glutamine and glutamic acid per serving. Mixes easily and is perfect for post-workout recovery or anytime you need a quality protein boost.",
                'variants' => [
                    ['name' => '1kg - Chocolate', 'sku' => 'ON-GSW-1KG-CHOC', 'price' => 9500, 'sale_price' => 8900, 'attributes' => ['size' => '1kg', 'flavor' => 'Chocolate']],
                    ['name' => '1kg - Vanilla Ice Cream', 'sku' => 'ON-GSW-1KG-VAN', 'price' => 9500, 'sale_price' => 8900, 'attributes' => ['size' => '1kg', 'flavor' => 'Vanilla Ice Cream']],
                    ['name' => '2kg - Chocolate', 'sku' => 'ON-GSW-2KG-CHOC', 'price' => 17500, 'attributes' => ['size' => '2kg', 'flavor' => 'Chocolate']],
                    ['name' => '2kg - Vanilla Ice Cream', 'sku' => 'ON-GSW-2KG-VAN', 'price' => 17500, 'sale_price' => 16500, 'attributes' => ['size' => '2kg', 'flavor' => 'Vanilla Ice Cream']],
                ],
            ],
            [
                'category' => 'Whey Protein',
                'brand' => 'Dymatize',
                'name' => 'Dymatize ISO100 Hydrolyzed Whey Protein Isolate',
                'sku' => 'DYM-ISO100-1.6LB',
                'price' => 12000,
                'stock_quantity' => 35,
                'short_description' => 'Fast-absorbing hydrolyzed whey protein isolate with 25g of protein and virtually zero fat, sugar or lactose.',
                'description' => 'ISO100 is a fast-digesting whey protein isolate that has been hydrolyzed for maximum absorption. Each serving delivers 25g of protein and 5.5g of BCAAs, with less than 1g of sugar and fat, making it ideal for lean muscle recovery.',
                'variants' => [
                    ['name' => '1.6lb - Gourmet Chocolate', 'sku' => 'DYM-ISO100-CHOC', 'price' => 12000, 'attributes' => ['size' => '1.6lb', 'flavor' => 'Gourmet Chocolate']],
                    ['name' => '1.6lb - Gourmet Vanilla', 'sku' => 'DYM-ISO100-VAN', 'price' => 12000, 'attributes' => ['size' => '1.6lb', 'flavor' => 'Gourmet Vanilla']],
                ],
            ],
            [
                'category' => 'Mass Gainers',
                'brand' => 'Optimum Nutrition',
                'name' => 'Optimum Nutrition Serious Mass Weight Gainer',
                'sku' => 'ON-SMASS-2.7KG',
                'price' => 11500,
                'stock_quantity' => 30,
                'is_featured' => true,
                'short_description' => '1,250 calories per serving with 50g of protein to help build muscle size and strength.',
                'description' => 'Serious Mass is a high-protein weight gainer formulated for hard gainers looking to bulk up. Each serving provides 1,250 calories, 50g of protein and added vitamins and minerals, plus creatine and glutamine.',
                'variants' => [
                    ['name' => '2.7kg - Chocolate', 'sku' => 'ON-SMASS-CHOC', 'price' => 11500, 'attributes' => ['size' => '2.7kg', 'flavor' => 'Chocolate']],
                    ['name' => '2.7kg - Vanilla', 'sku' => 'ON-SMASS-VAN', 'price' => 11500, 'attributes' => ['size' => '2.7kg', 'flavor' => 'Vanilla']],
                ],
            ],
            [
                'category' => 'Mass Gainers',
                'brand' => 'MuscleTech',
                'name' => 'MuscleTech Mass-Tech Extreme 2000',
                'sku' => 'MT-MASSTECH-3KG',
                'price' => 13000,
                'sale_price' => 12200,
                'stock_quantity' => 25,
                'short_description' => 'Advanced muscle-building formula delivering 80g of protein and 2,270 calories per serving.',
                'description' => 'Mass-Tech Extreme 2000 combines a research-backed blend of whey protein, creatine and complex carbs to help you pack on muscle size and strength, with 2,270 calories and 80g of protein per serving.',
                'variants' => [
                    ['name' => '3kg - Chocolate', 'sku' => 'MT-MASSTECH-CHOC', 'price' => 13000, 'sale_price' => 12200, 'attributes' => ['size' => '3kg', 'flavor' => 'Chocolate']],
                    ['name' => '3kg - Vanilla', 'sku' => 'MT-MASSTECH-VAN', 'price' => 13000, 'sale_price' => 12200, 'attributes' => ['size' => '3kg', 'flavor' => 'Vanilla']],
                ],
            ],
            [
                'category' => 'Pre-Workout',
                'brand' => 'BSN',
                'name' => 'BSN N.O.-Xplode Pre-Workout',
                'sku' => 'BSN-NOXPLODE',
                'price' => 8500,
                'stock_quantity' => 40,
                'is_featured' => true,
                'short_description' => 'Explosive energy, focus and pumps to power through your toughest workouts.',
                'description' => 'N.O.-Xplode is a pre-workout powder formulated with a blend of energizers, creatine and amino acids to support energy, focus and muscle pumps during training.',
                'variants' => [
                    ['name' => 'Fruit Punch', 'sku' => 'BSN-NOXPLODE-FP', 'price' => 8500, 'attributes' => ['flavor' => 'Fruit Punch']],
                    ['name' => 'Blue Raspberry', 'sku' => 'BSN-NOXPLODE-BR', 'price' => 8500, 'attributes' => ['flavor' => 'Blue Raspberry']],
                    ['name' => 'Watermelon', 'sku' => 'BSN-NOXPLODE-WM', 'price' => 8500, 'attributes' => ['flavor' => 'Watermelon']],
                ],
            ],
            [
                'category' => 'Pre-Workout',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Pre-Workout Ignite',
                'sku' => 'CF-IGNITE',
                'price' => 6500,
                'sale_price' => 5900,
                'stock_quantity' => 60,
                'short_description' => 'Locally formulated pre-workout with caffeine, beta-alanine and citrulline malate for energy and endurance.',
                'description' => 'Pre-Workout Ignite is made locally for the Sri Lankan market, combining caffeine, beta-alanine and citrulline malate to give you sustained energy, focus and endurance for any training session.',
                'variants' => [
                    ['name' => 'Tropical Punch', 'sku' => 'CF-IGNITE-TP', 'price' => 6500, 'sale_price' => 5900, 'attributes' => ['flavor' => 'Tropical Punch']],
                    ['name' => 'Green Apple', 'sku' => 'CF-IGNITE-GA', 'price' => 6500, 'sale_price' => 5900, 'attributes' => ['flavor' => 'Green Apple']],
                ],
            ],
            [
                'category' => 'Vitamins & Wellness',
                'brand' => 'Optimum Nutrition',
                'name' => 'Optimum Nutrition Opti-Men Multivitamin',
                'sku' => 'ON-OPTIMEN',
                'price' => 5500,
                'stock_quantity' => 45,
                'short_description' => 'Daily multivitamin formulated for active men, with vitamins, minerals, amino acids and antioxidants.',
                'description' => 'Opti-Men is a daily multivitamin designed for active men, providing a comprehensive blend of vitamins, minerals, amino acids and antioxidants to support energy, immunity and overall wellness.',
                'variants' => [
                    ['name' => '90 Tablets', 'sku' => 'ON-OPTIMEN-90T', 'price' => 5500, 'attributes' => ['size' => '90 tablets']],
                    ['name' => '150 Tablets', 'sku' => 'ON-OPTIMEN-150T', 'price' => 8200, 'attributes' => ['size' => '150 tablets']],
                ],
            ],
            [
                'category' => 'Vitamins & Wellness',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Omega-3 Fish Oil',
                'sku' => 'CF-OMEGA3-90',
                'price' => 3200,
                'stock_quantity' => 70,
                'short_description' => 'High-strength fish oil softgels rich in EPA and DHA to support heart, joint and brain health.',
                'description' => 'Each softgel delivers a high-strength dose of EPA and DHA omega-3 fatty acids to support cardiovascular health, joint mobility and cognitive function as part of a daily wellness routine.',
            ],
            [
                'category' => 'Sports Accessories',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Shaker Bottle 700ml',
                'sku' => 'CF-SHAKER-700',
                'price' => 1200,
                'stock_quantity' => 100,
                'short_description' => 'Leak-proof 700ml shaker bottle with stainless steel mixing ball and measurement markings.',
                'description' => 'A durable, leak-proof 700ml shaker bottle with a built-in stainless steel mixing ball for smooth, lump-free shakes, plus clear measurement markings on the side.',
                'variants' => [
                    ['name' => 'Black', 'sku' => 'CF-SHAKER-BLK', 'price' => 1200, 'attributes' => ['color' => 'Black']],
                    ['name' => 'Blue', 'sku' => 'CF-SHAKER-BLU', 'price' => 1200, 'attributes' => ['color' => 'Blue']],
                    ['name' => 'Red', 'sku' => 'CF-SHAKER-RED', 'price' => 1200, 'attributes' => ['color' => 'Red']],
                ],
            ],
            [
                'category' => 'Sports Accessories',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Training Gloves',
                'sku' => 'CF-GLOVES',
                'price' => 2800,
                'stock_quantity' => 80,
                'short_description' => 'Breathable padded gym gloves with wrist support for weightlifting and training.',
                'description' => 'Padded, breathable training gloves with adjustable wrist support, designed to improve grip and protect your hands during weightlifting and other gym workouts.',
                'variants' => [
                    ['name' => 'Small', 'sku' => 'CF-GLOVES-S', 'price' => 2800, 'attributes' => ['size' => 'S']],
                    ['name' => 'Medium', 'sku' => 'CF-GLOVES-M', 'price' => 2800, 'attributes' => ['size' => 'M']],
                    ['name' => 'Large', 'sku' => 'CF-GLOVES-L', 'price' => 2800, 'attributes' => ['size' => 'L']],
                    ['name' => 'Extra Large', 'sku' => 'CF-GLOVES-XL', 'price' => 2800, 'attributes' => ['size' => 'XL']],
                ],
            ],
            [
                'category' => 'Gym Equipment',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Adjustable Dumbbell Set (5-25kg)',
                'sku' => 'CF-DUMBBELL-25',
                'price' => 45000,
                'sale_price' => 42000,
                'stock_quantity' => 15,
                'is_featured' => true,
                'short_description' => 'Space-saving adjustable dumbbell pair, 5kg to 25kg per dumbbell with quick-change weight plates.',
                'description' => 'This adjustable dumbbell set lets you switch between 5kg and 25kg per dumbbell in seconds using a quick-change dial, replacing an entire rack of fixed weights while saving space at home.',
            ],
            [
                'category' => 'Gym Equipment',
                'brand' => 'Ceylon Fit',
                'name' => 'Ceylon Fit Premium Yoga Mat',
                'sku' => 'CF-YOGAMAT',
                'price' => 4500,
                'stock_quantity' => 50,
                'short_description' => 'Extra-thick non-slip yoga and exercise mat with carry strap, ideal for stretching and floor workouts.',
                'description' => 'An extra-thick, non-slip yoga and exercise mat that provides comfortable cushioning for yoga, stretching and floor workouts, complete with a carry strap for easy transport.',
                'variants' => [
                    ['name' => 'Purple', 'sku' => 'CF-YOGAMAT-PUR', 'price' => 4500, 'attributes' => ['color' => 'Purple']],
                    ['name' => 'Black', 'sku' => 'CF-YOGAMAT-BLK', 'price' => 4500, 'attributes' => ['color' => 'Black']],
                    ['name' => 'Teal', 'sku' => 'CF-YOGAMAT-TEAL', 'price' => 4500, 'attributes' => ['color' => 'Teal']],
                ],
            ],
        ];

        foreach ($products as $data) {
            $variants = $data['variants'] ?? [];

            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'category_id' => $categories[$data['category']]->id,
                    'brand_id' => $brands[$data['brand']]->id,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'description' => $data['description'],
                    'short_description' => $data['short_description'],
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'] ?? null,
                    'stock_quantity' => $data['stock_quantity'],
                    'is_active' => true,
                    'is_featured' => $data['is_featured'] ?? false,
                ]
            );

            foreach ($variants as $index => $variant) {
                ProductVariant::updateOrCreate(
                    ['sku' => $variant['sku']],
                    [
                        'product_id' => $product->id,
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'sale_price' => $variant['sale_price'] ?? null,
                        'stock_quantity' => 20,
                        'attributes' => $variant['attributes'] ?? [],
                        'is_default' => $index === 0,
                    ]
                );
            }
        }
    }
}
