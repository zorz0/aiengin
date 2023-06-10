const fs = require('fs');
const path = require('path');

const sourceDir = path.join(__dirname, './build');
const destDir = path.join(__dirname, '../public');

function copyDirectory(src, dest) {
    // Create the destination directory if it doesn't exist
    if (!fs.existsSync(dest)) {
        fs.mkdirSync(dest);
    }

    // Get all the files and folders in the source directory
    const files = fs.readdirSync(src);

    // Copy each file/folder to the destination directory
    for (const file of files) {
        const srcPath = path.join(src, file);
        const destPath = path.join(dest, file);

        // Check if the current file is a directory
        if (fs.lstatSync(srcPath).isDirectory()) {
            copyDirectory(srcPath, destPath); // Recursively copy subdirectory
        } else {
            fs.copyFileSync(srcPath, destPath); // Copy file
        }
    }
}

setTimeout(() => {
    fs.readdir(path.join(__dirname, '../public/static/js'), (err, files) => {
        if (err) throw err;

        // Iterate over the files and delete them
        for (const file of files) {
            fs.unlink(path.join(path.join(__dirname, '../public/static/js'), file), (err) => {
                if (err) throw err;
                console.log(`Deleted file: ${file}`);
            });
        }
    });
    fs.copyFile(path.join(__dirname, './build/index.html'), path.join(__dirname, '../resources/views/frontend/index.blade.php'), (err) => {
        if (err) throw err;
        console.log('Copied ./build/index.html');
    });
    setTimeout(() => {
        fs.unlink(path.join(__dirname, './build/index.html'), (err) => {
            if (err) throw err;
            console.log(`${path.join(__dirname, './build/index.html')} was deleted`);
        });
    }, 1000);
    setTimeout(() => {
        copyDirectory(sourceDir, destDir);
    }, 2000);
}, 5000);
