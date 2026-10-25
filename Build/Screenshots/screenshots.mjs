// Takes the screenshots of TYPO3 Explained from a running TYPO3 backend.
//
// Usage: node screenshots.mjs [name ...]
// Without names, all screenshots are taken. A name is the path of the
// image below Documentation/Images/AutomaticScreenshots/, without ".png".

import { mkdir } from 'node:fs/promises';
import { dirname } from 'node:path';
import { chromium } from 'playwright';

const baseUrl = process.env.TYPO3_BASE_URL ?? 'http://localhost:8080';
const target = process.env.SCREENSHOT_TARGET ?? '../../Documentation/Images/AutomaticScreenshots';
const username = process.env.TYPO3_USERNAME ?? 'j.doe';
const password = process.env.TYPO3_PASSWORD ?? 'Screenshots-2026!';

const modal = 'typo3-backend-modal dialog[open]';
// Space around an element that is cut out, so its border stays visible
const margin = 20;

// Opens the modal of the card with the given title in an Admin Tools
// module, such as "Analyze Database Structure" in System > Maintenance
const openCard = async ({ page, frame }, title) => {
  await frame.locator('.card', { hasText: title }).first().getByRole('button').first().click();
  await page.locator(modal).waitFor();
  await page.waitForTimeout(1000);
};

// Expands a section of an accordion in the open modal
const expand = async ({ page }, title) => {
  await page.locator(modal).getByRole('button', { name: title }).first().click();
  await page.waitForTimeout(800);
};

// Each screenshot opens a module from the module menu and shows the
// backend in a viewport of the given size:
//
//   card       scrolls the card with that title to the top of an Admin
//              Tools module
//   prepare    runs after the module has loaded, for example to open a
//              modal
//   highlight  frames an element of the open modal, to point at it
//   clip       cuts out an element, with a margin, instead of the viewport
//   url        opens a page instead of a module
//   fresh      takes the screenshot in a session of its own, which has not
//              confirmed the password for the Admin Tools yet
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
  'AdminTools/EditorAdminPrivileges': {
    module: 'system_maintenance',
    width: 1000,
    height: 440,
  },
  'AdminTools/UpgradeTools': {
    module: 'system_upgrade',
    width: 1000,
    height: 795,
  },
  'AdminTools/ExtensionScannerOpen': {
    module: 'system_upgrade',
    width: 1000,
    height: 420,
    card: 'Scan Extension Files',
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
  'AdminTools/InstallationWideOptions': {
    module: 'system_settings',
    width: 1000,
    height: 590,
    prepare: async (context) => {
      await openCard(context, 'Configure Installation-Wide Options');
      await expand(context, 'Image Processing');
    },
  },
  'AdminTools/ConfigureEntryPoint': {
    module: 'system_settings',
    width: 1000,
    height: 540,
    prepare: async (context) => {
      await openCard(context, 'Configure Installation-Wide Options');
      await context.page.locator(modal).getByRole('searchbox').fill('entry');
      await context.page.waitForTimeout(800);
    },
  },
  'AdminTools/PasswordHashingSettings': {
    module: 'system_settings',
    width: 1000,
    height: 640,
    prepare: async (context) => {
      await openCard(context, 'Configuration Presets');
      await expand(context, 'Password hashing settings');
      await context.page.locator(modal).getByRole('button', { name: 'Debug settings' })
        .evaluate((button) => button.scrollIntoView({ block: 'start' }));
    },
  },
  'AdminTools/ChangeInstallToolPassword': {
    module: 'system_settings',
    width: 1000,
    height: 370,
    card: 'Change Install Tool Password',
  },
  'AdminTools/DirectoryStatus': {
    module: 'system_environment',
    width: 1000,
    height: 540,
    prepare: async (context) => {
      await openCard(context, 'Directory Status');
    },
    highlight: 'button:has-text("Try to fix file and folder permissions")',
  },
  'AdminTools/SudoMode': {
    module: 'system_maintenance',
    width: 1000,
    height: 540,
    fresh: true,
    prepare: async ({ page }) => {
      await page.locator(modal).locator('input[type="password"]').fill(password);
    },
    clip: modal,
  },
  'AdminTools/EnableInstallTool': {
    url: `${baseUrl}/typo3/install.php`,
    width: 1000,
    height: 700,
    clip: '.typo3-install-content',
  },
};

const login = async (page) => {
  await page.goto(`${baseUrl}/typo3/`);
  await page.fill('#t3-username', username);
  await page.fill('#t3-password', password);
  await page.click('#t3-login-submit');
  await page.waitForURL(/\/typo3\/(main|module)/);
};

// The Admin Tools modules ask for the password once per session
const confirmPassword = async (page) => {
  const dialog = page.locator(modal);
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
const openModule = async (page, identifier, confirm) => {
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
  if (confirm) {
    await confirmPassword(page);
  }
  await link.evaluate((element) => element.scrollIntoView({ block: 'nearest' }));
};

// Scrolls the card with the given title to the top of the module, below
// its sticky header. The mouse wheel scrolls whichever element
// holds the module.
const scrollToCard = async (page, frame, title) => {
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

const take = async (page, name, screenshot) => {
  await page.setViewportSize({ width: screenshot.width, height: screenshot.height });
  const frame = page.frameLocator('iframe[name="list_frame"]');
  if (screenshot.url) {
    await page.goto(screenshot.url);
    await page.waitForLoadState('networkidle');
  } else {
    await page.goto(`${baseUrl}/typo3/main`);
    await page.waitForLoadState('networkidle');
    await openModule(page, screenshot.module, !screenshot.fresh);
    if (!screenshot.fresh) {
      // Admin Tools modules load their cards after the page
      await frame.locator('.card').first().waitFor();
      await page.waitForTimeout(500);
    }
  }
  if (screenshot.card) {
    await scrollToCard(page, frame, screenshot.card);
  }
  if (screenshot.prepare) {
    await screenshot.prepare({ page, frame });
    await page.waitForTimeout(500);
  }
  // A hovered or focused element would look selected, except for the
  // password field that is being filled in
  await page.mouse.move(0, 0);
  if (!screenshot.fresh) {
    await page.evaluate(() => document.activeElement?.blur());
  }
  if (screenshot.highlight) {
    await page.locator(modal).locator(screenshot.highlight).evaluate((element) => {
      element.style.outline = '4px solid #ff8700';
      element.style.outlineOffset = '4px';
    });
  }
  await page.waitForTimeout(300);
  const path = `${target}/${name}.png`;
  await mkdir(dirname(path), { recursive: true });
  if (screenshot.clip) {
    const box = await page.locator(screenshot.clip).first().boundingBox();
    const x = Math.max(box.x - margin, 0);
    const y = Math.max(box.y - margin, 0);
    await page.screenshot({
      path,
      clip: {
        x,
        y,
        width: box.x + box.width + margin - x,
        height: box.y + box.height + margin - y,
      },
    });
  } else {
    await page.screenshot({ path });
  }
  console.log(`${name}.png`);
};

const browser = await chromium.launch();
const page = await browser.newPage();
await login(page);

const names = process.argv.length > 2 ? process.argv.slice(2) : Object.keys(screenshots);
for (const name of names) {
  const screenshot = screenshots[name];
  if (screenshot === undefined) {
    throw new Error(`Unknown screenshot "${name}"`);
  }
  if (screenshot.fresh) {
    const context = await browser.newContext();
    const freshPage = await context.newPage();
    await login(freshPage);
    await take(freshPage, name, screenshot);
    await context.close();
  } else {
    await take(page, name, screenshot);
  }
}
await browser.close();
