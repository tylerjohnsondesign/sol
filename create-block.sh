#!/bin/bash
red=`tput setaf 1`
green=`tput setaf 2`
yellow=`tput setaf 3`
blue=`tput setaf 4`
magenta=`tput setaf 5`
cyan=`tput setaf 6`
reset=`tput sgr0`

# =======================================================
# Command: bash create-block.sh -- Create Block via Bash Script
# =======================================================

# Set directory blocks directory.
cur_dir=$(pwd)/blocks;

# Welcome.
printf " [$(TZ=America/Detroit date +'%x %X %Z')] 🛠️ ${green} Hello! Let's build a new block. ${reset} \n";

# Ask for block name.
printf "\n [$(TZ=America/Detroit date +'%x %X %Z')] 🔌 ${yellow}What is the name of the block?${reset} \n";
read -p " [$(TZ=America/Detroit date +'%x %X %Z')] 🔌 ${yellow}Block Name:${reset} " block_name

# Ask for block slug and convert to lowercase with hyphens.
printf "\n [$(TZ=America/Detroit date +'%x %X %Z')] 🐌 ${yellow}What is the slug of the block?${reset} \n";
read -p " [$(TZ=America/Detroit date +'%x %X %Z')] 🐌 ${yellow}Block Slug:${reset} " block_slug
block_slug=$(echo "$block_slug" | tr '[:upper:]' '[:lower:]' | sed 's/ /-/g')

# Ask for block description.
printf "\n [$(TZ=America/Detroit date +'%x %X %Z')] 📝 ${yellow}What is the description of the block?${reset} \n";
read -p " [$(TZ=America/Detroit date +'%x %X %Z')] 📝 ${yellow}Block Description:${reset} " block_description

# Ask if block should have compiled assets. 
printf "\n [$(TZ=America/Detroit date +'%x %X %Z')] 📦 ${yellow}Should the block have compiled assets?${reset} \n"
echo -n " [$(TZ=America/Detroit date +'%x %X %Z')] 📦 Block Compiled Assets (y/n): "
read block_compiled_assets
if [[ $block_compiled_assets =~ ^[Yy]$ ]]; then
    block_compiled_assets=true
else
    block_compiled_assets=false
fi

# Confirming build.
printf " [$(TZ=America/Detroit date +'%x %X %Z')] 🛠️ ${green} Building block in ${cur_dir}/${block_slug}...${reset} \n\n";

# =======================================================
# Create block directory.
# =======================================================
mkdir -p "${cur_dir}/${block_slug}";
# Create block.json file.
cat <<EOL > "${cur_dir}/${block_slug}/block.json"
{
    "apiVersion": 2,
    "version": "1.0.0",
    "name": "acf/${block_slug}",
    "title": "${block_name}",
    "description": "${block_description}",
    "category": "design",
    "icon": "admin-generic",
    "keywords": [],
    "acf": {
        "mode": "preview",
        "renderTemplate": "${block_slug}.php"
    },
    "supports": {
        "anchor": true,
        "align": true,
        "ariaLabel": true,
        "background": {
            "backgroundImage": true,
            "backgroundSize": true
        },
        "className": true,
        "color": {
            "background": true,
            "button": true,
            "heading": true,
            "link": true,
            "text": true
        },
        "html": false,
        "shadow": true,
        "spacing": {
            "margin": true,
            "padding": true,
            "blockGap": true
        },
        "typography": {
            "fontSize": true,
            "lineHeight": true,
            "textAlign": true
        }
    },
    "attributes": {
        "style": { "type": "object" }
    }
}
EOL

# Create PHP file.
cat <<EOL > "${cur_dir}/${block_slug}/${block_slug}.php"
<?php
/**
 * ${block_name}.
 * @param   array    \$block  The block settings and attributes.
 * @since            1.0.0
 */
use SOL\Inc\blocks;

// Get block attributes.
\$attrs = get_block_wrapper_attributes( blocks::get_args( \$block ) ); ?>
<div <?php echo \$attrs; ?>>
    <div class="sol-${block_slug}__container">
    </div>
</div>
EOL

# Check if compiled assets are needed
if [ "$block_compiled_assets" = true ]; then
    # Set location.
    asset_location="${cur_dir}/${block_slug}/";
    # Create blank JS file.
    touch "${cur_dir}/${block_slug}/${block_slug}.js";
    # Create blank SCSS file.
    touch "${cur_dir}/${block_slug}/${block_slug}.scss";
else
    # Create file in block directory/assets.
    mkdir -p "${cur_dir}/${block_slug}/assets";
    # Set location.
    asset_location="${cur_dir}/${block_slug}/assets/";
    # Create empty JS file.
    touch "${cur_dir}/${block_slug}/assets/${block_slug}.js";
    # Create empty SCSS file.
    touch "${cur_dir}/${block_slug}/assets/${block_slug}.scss";
fi

echo "Assets will be created in: ${asset_location}";

# Add content to JS file.
cat <<EOL > "${asset_location}/${block_slug}.js"
/**
 * ${block_name} Block JavaScript.
 * @since   1.0.0
 */
jQuery(document).ready(function($) {
    // Add your block JavaScript here.
    console.log('Block ${block_slug} initialized.');
});
EOL

# Add content to SCSS file.
cat <<EOL > "${asset_location}/${block_slug}.scss"
/**
 * ${block_name} Block Styles.
 * @since   1.0.0
 */
.sol-${block_slug} {
    // Add your block styles here.
    &__container {
        // Container styles.
    }
}
EOL

# Add single block slug to inc/class-blocks.php method `define_blocks`, below // Add blocks. as $blocks[] = 'slug';
blocks_file="${cur_dir}/../inc/class-blocks.php";
if grep -q "// Add blocks." "$blocks_file"; then
    # Insert the block slug into the file with tab.
    sed -i "/\/\/ Add blocks./a \            '$block_slug'," "$blocks_file"
else
    # If the comment is not found, append the block slug at the end of the file.
    echo "        '$block_slug'," >> "$blocks_file"
fi

# All done!
printf " [$(TZ=America/Detroit date +'%x %X %Z')] ✅ ${green} Block ${block_name} created successfully in ${cur_dir}/${block_slug}. ${reset} \n";
