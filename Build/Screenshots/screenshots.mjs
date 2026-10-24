// Takes the screenshots of TYPO3 Explained from a running TYPO3 backend.
//
// Usage: node screenshots.mjs [name ...]
// Without names, all screenshots are taken. A name is the path of the
// image below Documentation/Images/ManualScreenshots/, without ".png".

import { mkdir } from 'node:fs/promises';
import { dirname } from 'node:path';
import { chromium } from 'playwright';

const baseUrl = process.env.TYPO3_BASE_URL ?? 'http://localhost:8080';
const target = process.env.SCREENSHOT_TARGET ?? '../../Documentation/Images/ManualScreenshots';
const username = process.env.TYPO3_USERNAME ?? 'j.doe';
const password = process.env.TYPO3_PASSWORD ?? 'Screenshots-2026!';

// Each screenshot opens a module from the module menu and shows the
// backend in a viewport of the given size. "card" scrolls the card with
// that title to the top of an Admin Tools module.
const screenshots = {
  'AdminTools/AdminToolsSettings': {
    module: 'system_settings',
    width: 1000,
    height: 460,
  },
  'AdminTools/AnalyzeDatabase': {
    module: 'system_maintenance',
    width: 1000,
    height: 370,
    card: 'Analyze Database Structure',
  },
  'AdminTools/MaintenanceRemoveTemporaryAssets': {
    module: 'system_maintenance',
    width: 1000,
    height: 370,
    card: 'Remove Temporary Assets',
  },
  'AdminTools/UpgradeTools': {
    module: 'system_upgrade',
    width: 1000,
    height: 795,
  },
  'AdminTools/FeatureToggles': {
    module: 'system_settings',
    width: 1000,
    height: 370,
    card: 'Feature Toggles',
  },
  'AdminTools/AllConfiguration': {
    module: 'system_settings',
    width: 1000,
    height: 370,
    card: 'Configure Installation-Wide Options',
  },
  'AdminTools/ChangeInstallToolPassword': {
    module: 'system_settings',
    width: 1000,
    height: 370,
    card: 'Change Install Tool Password',
  },
};

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1280, height: 1000 } });
await page.goto(`${baseUrl}/typo3/`);
await page.fill('#t3-username', username);
await page.fill('#t3-password', password);
await page.click('#t3-login-submit');
await page.waitForURL(/\/typo3\/(main|module)/);

// The Admin Tools modules ask for the password once per session
const confirmPassword = async () => {
  const dialog = page.locator('typo3-backend-modal dialog[open]');
  const field = dialog.locator('input[type="password"]');
  if (await field.count() > 0) {
    await field.fill(password);
    await field.press('Enter');
    await dialog.waitFor({ state: 'detached' });
    await page.waitForTimeout(800);
  }
};

// Expands the group of the module and collapses the other groups, so the
// menu shows where the module is, then opens the module
const openModule = async (identifier) => {
  const link = page.locator(`#modulemenu a[data-modulemenu-identifier="${identifier}"]`);
  const groups = page.locator('#modulemenu button.modulemenu-action[aria-expanded]');
  for (const group of await groups.all()) {
    const contains = await group.evaluate(
      (button, id) => button.parentElement
        .querySelector(`a[data-modulemenu-identifier="${id}"]`) !== null,
      identifier,
    );
    if ((await group.getAttribute('aria-expanded') === 'true') !== contains) {
      await group.click();
    }
  }
  await page.waitForTimeout(400);
  await link.click();
  await page.waitForTimeout(800);
  await confirmPassword();
  await link.evaluate((element) => element.scrollIntoView({ block: 'nearest' }));
};

// Scrolls the card with the given title to the top of the module, below
// its sticky header. The mouse wheel scrolls whichever element
// holds the module.
const scrollToCard = async (frame, title) => {
  const card = frame.locator('.card', { hasText: title }).first();
  const top = 126;
  await page.mouse.move(600, 300);
  for (let i = 0; i < 5; i++) {
    const box = await card.boundingBox();
    if (Math.abs(box.y - top) < 2) {
      break;
    }
    await page.mouse.wheel(0, box.y - top);
    await page.waitForTimeout(300);
  }
};

const names = process.argv.length > 2 ? process.argv.slice(2) : Object.keys(screenshots);
for (const name of names) {
  const screenshot = screenshots[name];
  if (screenshot === undefined) {
    throw new Error(`Unknown screenshot "${name}"`);
  }
  await page.setViewportSize({ width: screenshot.width, height: screenshot.height });
  await page.goto(`${baseUrl}/typo3/main`);
  await page.waitForLoadState('networkidle');
  await openModule(screenshot.module);
  // Resolves to the document the module frame shows at the moment
  const frame = page.frameLocator('iframe[name="list_frame"]');
  // Admin Tools modules load their cards after the page
  await frame.locator('.card').first().waitFor();
  await page.waitForTimeout(500);
  if (screenshot.card) {
    await scrollToCard(frame, screenshot.card);
  }
  if (screenshot.prepare) {
    await screenshot.prepare(frame);
    await page.waitForTimeout(1500);
  }
  // A hovered or focused element would look selected
  await page.mouse.move(0, 0);
  await page.evaluate(() => document.activeElement?.blur());
  await page.waitForTimeout(300);
  const path = `${target}/${name}.png`;
  await mkdir(dirname(path), { recursive: true });
  if (screenshot.modal) {
    await page.locator('typo3-backend-modal dialog[open]').waitFor();
    await page.waitForTimeout(500);
  }
  await page.screenshot({ path });
  console.log(`${name}.png`);
}
await browser.close();
