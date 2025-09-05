const fs = require("fs");
const path = require("path");
const readline = require("readline");

// Configuration
const SEARCH_REPLACE_PAIRS = [
    { search: "surfalert", replace: "surfalert", caseSensitive: true },
    { search: "SURFALERT_", replace: "SURFALERT_", caseSensitive: true },
    { search: "sa-", replace: "sa-", caseSensitive: true },
    { search: "sa_", replace: "sa_", caseSensitive: true },
];

// File extensions to process
const FILE_EXTENSIONS = [
    ".php",
    ".js",
    ".css",
    ".html",
    ".txt",
    ".json",
    ".xml",
    ".md",
    ".yml",
    ".yaml",
];

// Function to process a file
function processFile(filePath) {
    fs.readFile(filePath, "utf8", (err, data) => {
        if (err) {
            console.error(`Error reading file ${filePath}:`, err);
            return;
        }

        let newData = data;
        let changesMade = false;

        // Apply all search/replace pairs
        SEARCH_REPLACE_PAIRS.forEach((pair) => {
            const flags = pair.caseSensitive ? "g" : "gi";
            const regex = new RegExp(pair.search, flags);

            if (regex.test(newData)) {
                changesMade = true;
                newData = newData.replace(regex, pair.replace);
            }
        });

        // Write back to file if changes were made
        if (changesMade) {
            fs.writeFile(filePath, newData, "utf8", (err) => {
                if (err) {
                    console.error(`Error writing file ${filePath}:`, err);
                } else {
                    console.log(`Updated: ${filePath}`);
                }
            });
        }
    });
}

// Function to walk through directories
function walkDir(dir, callback) {
    fs.readdir(dir, (err, files) => {
        if (err) throw err;

        files.forEach((file) => {
            const filePath = path.join(dir, file);

            fs.stat(filePath, (err, stats) => {
                if (err) {
                    console.error(`Error stating file ${filePath}:`, err);
                    return;
                }

                if (stats.isDirectory()) {
                    // Skip node_modules and vendor directories
                    if (file !== "node_modules" && file !== "vendor") {
                        walkDir(filePath, callback);
                    }
                } else if (stats.isFile()) {
                    // Check if file extension matches
                    const ext = path.extname(file).toLowerCase();
                    if (FILE_EXTENSIONS.includes(ext)) {
                        callback(filePath);
                    }
                }
            });
        });
    });
}

// Main function
function main() {
    const rl = readline.createInterface({
        input: process.stdin,
        output: process.stdout,
    });

    console.log(
        "This script will perform the following search and replace operations:"
    );
    SEARCH_REPLACE_PAIRS.forEach((pair) => {
        console.log(
            `- "${pair.search}" → "${pair.replace}" (case-sensitive: ${pair.caseSensitive})`
        );
    });

    rl.question("\nAre you sure you want to continue? (y/N): ", (answer) => {
        if (answer.toLowerCase() === "y" || answer.toLowerCase() === "yes") {
            console.log("\nStarting search and replace...");

            // Start from current directory
            const startDir = process.cwd();
            walkDir(startDir, processFile);

            console.log(
                "Search and replace completed. Please verify the changes."
            );
        } else {
            console.log("Operation cancelled.");
        }

        rl.close();
    });
}

// Run the script
main();
