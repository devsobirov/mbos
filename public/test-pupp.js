const puppeteer = require('puppeteer');
// Get command-line arguments starting from index 2
const [url, filename] = process.argv.slice(2);


(async () => {
    const browser = await puppeteer.launch({
        headless: 'new', // Use the new Headless mode
        args: ['--no-sandbox']
    });
    const page = await browser.newPage();

    // Optional: Log console messages for debugging
    page.on('console', message => console.log(`Console: ${message.text()}`));

    try {

        // Navigate to the webpage
        await page.goto(url);

        // Wait for some time or specific elements to appear
        await page.waitForTimeout(10000); // 2 seconds, for example

        // Take a screenshot
        await page.screenshot({ path: filename, fullPage: true });

        console.log('screenshot-succeed');
    } catch (error) {
        console.error('Error occurred:', error);
    } finally {
        // Close the browser
        await browser.close();
    }
})();
