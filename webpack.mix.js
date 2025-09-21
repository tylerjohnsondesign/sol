const mix = require('laravel-mix');
const path = require('path');
const fs = require('fs');
const glob = require('glob');

// Gather all block entry JS and SCSS files for main bundle
const blockEntryJS = [];
const blockEntrySCSS = [];

const blockDirs = glob.sync('blocks/*');

blockDirs.forEach(blockDir => {
    const blockName = path.basename(blockDir);

    // Collect block entry files for main bundle
    const jsPath = `${blockDir}/${blockName}.js`;
    const scssPath = `${blockDir}/${blockName}.scss`;

    if (fs.existsSync(jsPath)) {
        blockEntryJS.push(jsPath);
    }
    if (fs.existsSync(scssPath)) {
        blockEntrySCSS.push(scssPath);
    }

    // Compile/minify each asset file individually (not merged into main.js/css)
    // Skip any .min.js or .min.css files
    const assetJS = glob.sync(`${blockDir}/assets/*.js`).filter(js => !js.endsWith('.min.js'));
    const assetSCSS = glob.sync(`${blockDir}/assets/*.scss`).filter(scss => !scss.endsWith('.min.css'));

    assetJS.forEach(js => {
        const name = path.basename(js, '.js');
        mix.js(js, `${blockDir}/assets/${name}.min.js`);
    });

    assetSCSS.forEach(scss => {
        const name = path.basename(scss, '.scss');
        mix.sass(scss, `${blockDir}/assets/${name}.min.css`);
    });
});

// --- AUTOMATE SCSS IMPORTS ---
const mainScssPath = path.resolve(__dirname, 'src/main.scss');
let mainScssContent = '';
if (fs.existsSync(mainScssPath)) {
    mainScssContent = fs.readFileSync(mainScssPath, 'utf8');
}
// Remove previous auto-generated imports
mainScssContent = mainScssContent.replace(/\/\/ AUTO-IMPORTS START[\s\S]*?\/\/ AUTO-IMPORTS END\n?/g, '');
// Generate new imports
const autoImports = blockEntrySCSS
    .map(scssPath => `@import "../${scssPath.replace(/\\/g, '/')}";`)
    .join('\n');
const autoImportBlock = `// AUTO-IMPORTS START\n${autoImports}\n// AUTO-IMPORTS END\n`;
// Prepend to main.scss
mainScssContent = `${autoImportBlock}${mainScssContent}`;
fs.writeFileSync(mainScssPath, mainScssContent);

// Main bundles: include src/ and all block entry files
mix.js(['src/main.js', ...blockEntryJS], 'dist/main.js')
   .sass('src/main.scss', 'dist/main.css');

if (mix.inProduction()) {
    mix.version();
}