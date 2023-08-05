// eslint-disable-next-line no-undef
const fs = require('fs');
// eslint-disable-next-line no-undef
const path = require('path');

// eslint-disable-next-line no-undef
const distPath = path.resolve(__dirname, 'dist/assets');

fs.readdir(distPath, (err, files) => {
  if (err) {
    console.error('Error reading dist directory:', err);
    return;
  }

  const manifest = {};
  files.forEach((file) => {
    const filePath = path.join(distPath, file);
    const stats = fs.statSync(filePath);
    if (stats.isFile()) {
      const originalFileName = file.split('.')[0];
      manifest[`/${originalFileName}`] = `/${file}`;
    }
  });

  fs.writeFile('dist/manifest.json', JSON.stringify(manifest, null, 2), (err) => {
    if (err) {
      console.error('Error writing manifest file:', err);
      return;
    }
    console.log('Manifest file generated successfully.');
  });
});
