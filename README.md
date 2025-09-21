<a href="https://tylerjohnsondesign.com/"><img src="https://tylerjohnsondesign.com/wp-content/themes/builtmighty/assets/svg/footer-logo.svg" style="max-width:250px;" /></a>

## About
Get started with this child theme in just two simple steps.

1. Navigate to the root directory of your WordPress instance.
2. Run the following command and answer the questions.

```
git clone https://<your-github-username>:<your-personal-access-token>@github.com/builtmighty/create-sol.git && cd create-sol && bash create-sol.sh && cd ../
```

## Adding Classes
This theme uses the Simpleton method for initiating classes. From there, we leave it fairly open. To load and initiate a new class, do the following.

1. Within the main theme `functions.php` file, load the class within the `load()` method.
```PHP
require_once SOL_PATH . 'inc/class-new.php';
```
2. If you want to initialize a class, you can do so within the `init.php` file, which is in the base theme directory. To initiate, add the class within the `init_classes()` method.
```PHP
$this->load_class( \SOL\Inc\new::class );
```

## Creating Blocks
Creating a block is extremely easy. To do so, navigate to the child theme directory and run the following.
```
bash create-block.sh
```
And answer the questions. You'll be asked for the block name (capitalized), block slug (lower-case and dash-separated), block description, and if assets should be merged into the main scripts/stylesheets or loaded individually if the block is used.

## Laravel Mix
By default, the theme comes pre-packaged with a smart version of Laravel Mix. This version compiles and merges all assets in `blocks/block_name` into `dist/main.css` and `dist/main.js`. It also compiles and loads any assets within `blocks/block_name/assets/`. To get started, please navigate to the theme directory in your terminal.

1. To install dependencies.
```CLI
npm install
```
2. To compile assets for development.
```CLI
npm run dev
```
3. To watch for changes.
```CLI
npm run watch
```
4. To build for production.
```CLI
npm run prod
```

## ACF Colors
This theme comes with limited colors to help keep onbrand. You can modify any colors by editing the `define_colors()` method within `inc/class-theme.php`, or you can filter using `add_filter( 'child_theme_colors', 'your_function', 10, 1 );`, which filters an array of $colors. Currently, the following colors are set by default.

* Black
* White

Any color picker fields will be limited to these colors, and any colors will be converted to classes for use on the front end automatically. To retrieve a class name for use within a template, use the static method `blocks::get_color( $color, $type )`. For the color variable, send a HEX color code. For the type, it'll default to `color`, but you can pass `background` to get a background color class. 

## ACF Block Fields

You'll need some ACF fields to connect to the block. *Make sure you sync the ACF fields from `acf-json/` within the ACF settings.* From the ACF field group location, duplicate `[BLOCK] Base`. This block contains some base fields, which are helpful for quickly formatting and creating blocks. Specifically, it has preformatted tabs for: content, style, and layout.

The content section is for any content the user might add, such as titles, body text, links, etc. The style section is for defining fonts, colors, and backgrounds for specific pieces of the content. And finally, the layout section is for defining padding, margins, and specific IDs or classes for the block.

By default, backgrounds are built into the styles section within the base block. The background section supports a background color, background image, or background video from YouTube or Vimeo. Additionally, by default, the layout section includes padding for top, right, bottom, and left, as well as margins for those locations as well, along with an ID field and class field.

Then, load your fields into the `blocks/your-block.php` template for output. You can use this basic template to get started. All content should be placed within `sol-your-block__container`.

## 1.0.0
* Initial Release
