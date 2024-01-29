const puppeteer = require('puppeteer');
//const fs = require('fs');

const [encodedHtml, filename, logPath] = process.argv.slice(2);
//fs.appendFileSync(logPath, "Tyring");
(async () => {
    const browser = await puppeteer.launch({
        headless: 'new',
        args: ['--no-sandbox']
    });
    const page = await browser.newPage();

    // Optional: Log console messages for debugging
    page.on('console', message => console.log(`Console: ${message.text()}`));

    try {
        const htmlContent = Buffer.from(encodedHtml, 'base64').toString('utf-8');

        await page.setContent(htmlContent);

        console.log('Puppeteer is processing...');
        await page.waitForTimeout(10000); // 10 seconds for loading a page

        console.log('Capturing screenshot...');
        await page.screenshot({ path: filename, fullPage: true });
        console.log('Screenshot succeeded');

    } catch (error) {
        console.error('Error occurred:', error);

        //Log the error to a file
        const logMessage = `Error occurred: ${error.message}\n${error.stack}\n\n`;
        //fs.appendFileSync(logPath, logMessage);

    } finally {
        // Close the browser
        await browser.close();
    }
})();

