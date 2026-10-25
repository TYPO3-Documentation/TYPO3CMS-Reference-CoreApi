// Takes the screenshots of TYPO3 Explained from a running TYPO3 backend.
//
// Usage: node screenshots.mjs [name ...]
// Without names, all screenshots are taken. A name is the path of the
// image below Documentation/Images/AutomaticScreenshots/, without ".png".

import { existsSync, readFileSync } from 'node:fs';
import { mkdir, writeFile } from 'node:fs/promises';
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

// The marks drawn on a screenshot, the same in all manuals that take their
// screenshots automatically: an orange frame around an element, and a
// number in an orange circle at the lower right of an element, for a text
// that explains the numbered parts. "left" puts the circle at the lower
// left, where a neighbour follows closely on the right.
const outline = (locator, inside = false) => locator.evaluate((element, inner) => {
  element.style.outline = '3px solid #ff8700';
  element.style.outlineOffset = inner ? '-3px' : '3px';
}, inside);
const badge = (locator, number, side = 'right') => locator.evaluate((element, [text, where]) => {
  const box = element.getBoundingClientRect();
  const circle = element.ownerDocument.createElement('span');
  // The clip takes in every circle, see area()
  circle.className = 'screenshot-badge';
  circle.textContent = text;
  Object.assign(circle.style, {
    position: 'fixed',
    left: `${where === 'left' ? box.left - 14 : box.right - 12}px`,
    top: `${box.bottom - 6}px`,
    width: '26px',
    height: '26px',
    borderRadius: '50%',
    background: '#ff8700',
    color: '#fff',
    font: 'bold 15px sans-serif',
    zIndex: '10000',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    boxShadow: '0 1px 3px rgba(0, 0, 0, 0.4)',
  });
  element.ownerDocument.body.appendChild(circle);
}, [String(number), side]);

// The card of a site in Sites > Setup, by the title of its root page
const siteCard = (frame, title) => frame.locator(`.card:has(.card-title:text-is("${title}"))`);

// A field of the site form, by its name
const siteField = (frame, name) => frame.locator(`[data-formengine-input-name$="[${name}]"]`).first();

// Fills in a field of a form and marks it as changed right away, as
// FormEngine otherwise marks it only once the focus leaves it
const fillIn = async (field, value) => {
  await field.fill(value);
  await field.dispatchEvent('change');
};

// Opens the form of a new site configuration for the page without one
const createSite = async ({ page, frame }) => {
  await frame.locator('a, button', { hasText: 'Add new site configuration' }).first().click();
  await frame.locator('h1', { hasText: 'Create new site' }).waitFor();
  // The set comes first, as choosing it renders the form anew, which
  // forgets which fields changed. A click on an available item moves it to
  // the selected ones, once the list has the focus.
  const selected = frame.locator('select[data-formengine-input-name$="[dependencies]"] option');
  while (await selected.count() === 0) {
    await frame.locator('option', { hasText: '[typo3/fluid-styled-content]' }).last().click();
    await page.waitForTimeout(500);
  }
  // Marks the set field as changed right away, like fillIn
  await frame.locator('select[data-formengine-input-name$="[dependencies]"]').dispatchEvent('change');
  await page.waitForTimeout(1500);
  await fillIn(siteField(frame, 'identifier'), 'my-other-site');
  await fillIn(siteField(frame, 'websiteTitle'), 'My other site');
  await fillIn(siteField(frame, 'base'), 'https://my-other-site.example.org/');
  // The border of a changed field fades to its new color
  await page.waitForTimeout(2000);
};

// Opens the form of the site configuration "camino"
const editSite = async ({ page, frame }) => {
  await siteCard(frame, 'Camino').getByTitle('Edit site configuration').click();
  await frame.locator('h1', { hasText: 'Site configuration' }).waitFor();
  await page.waitForTimeout(500);
};

// The innermost form group of a field, by the field name that debug mode
// shows next to the label
const fieldGroup = (frame, name) => frame.locator(`.form-group:has(code:text-is("[${name}]"))`).last();

// Opens a part of the module Administration > Users, such as "File mounts".
// The module opens the part that was open last.
const usersModulePart = (title) => async ({ page, frame }) => {
  await frame.locator('.module-docheader .dropdown-toggle', { hasText: 'Module Menu' }).first().click();
  await frame.locator('.dropdown-item', { hasText: title }).first().click();
  await frame.locator('h1', { hasText: title }).first().waitFor();
  await page.waitForTimeout(800);
  // The module also remembers the filter of the list of users
  const userName = frame.locator('input[name*="[userName]"]');
  if (await userName.count() > 0 && await userName.first().inputValue() !== '') {
    await frame.locator('button[value="reset-filters"]').first().click();
    await frame.locator('h1', { hasText: title }).first().waitFor();
    await page.waitForTimeout(800);
  }
};

// Opens the form of a new backend group from Administration > Users
const createGroup = async (context) => {
  const { page, frame } = context;
  await usersModulePart('Backend user groups')(context);
  await frame.locator('.module-docheader a', { hasText: 'Create new backend user group' }).first().click();
  await frame.locator('h1', { hasText: 'Create new' }).waitFor();
  await fillIn(siteField(frame, 'title'), 'Simple Editor');
  await page.waitForTimeout(500);
};

// Opens a tab of the form in the module frame
const openTab = (title) => async ({ page, frame }) => {
  await frame.getByRole('tab', { name: title }).click();
  await page.waitForTimeout(500);
};

// Expands a group of a field with checkboxes, such as "Category" in the
// allowed fields, and checks the items that end in the given names
const checkItems = async ({ page, frame }, field, group, items) => {
  const groupElement = fieldGroup(frame, field);
  await groupElement.locator('.panel-heading, .panel-button, button', { hasText: group }).first().click();
  await page.waitForTimeout(500);
  for (const item of items) {
    await groupElement.locator('tr', { hasText: item }).locator('input[type="checkbox"]').first().check();
  }
};

// Each screenshot opens a module from the module menu and shows the
// backend in a viewport of the given size:
//
//   card       scrolls the card with that title to the top of an Admin
//              Tools module
//   prepare    runs after the module has loaded, for example to open a
//              modal
//   keepFocus  keeps the focus where prepare left it, for a list of
//              suggestions that closes with the focus
//   mark       draws frames and numbers with outline() and badge(), after
//              the focus is gone
//   clip       cuts out an element, with a margin, instead of the viewport,
//              or the area from one element of the module to another
//   margin     the space around a clip, instead of the default
//   scrollTo   scrolls an element of the module to the given top
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
    mark: ({ page }) => outline(
      page.locator(modal).locator('button:has-text("Try to fix file and folder permissions")'),
    ),
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
  'SiteHandling/SiteConfigurationOverview': {
    module: 'site_configuration',
    width: 1000,
    height: 700,
    // Notes about the sites stand above the list
    scrollTo: (frame) => [frame.locator('h2', { hasText: 'Sites' }), 180],
    clip: (frame) => [
      frame.locator('h2', { hasText: 'Sites' }),
      siteCard(frame, 'Camino').locator('.card-footer'),
    ],
    margin: 12,
  },
  'SiteHandling/SiteHandlingCreateNewSite-1': {
    module: 'site_configuration',
    width: 1000,
    height: 700,
    scrollTo: (frame) => [siteCard(frame, 'My site'), 180],
    clip: (frame) => [siteCard(frame, 'My site'), siteCard(frame, 'My site').locator('.card-footer')],
    margin: 8,
  },
  'SiteHandling/SiteHandlingNoSite': {
    module: 'site_configuration',
    width: 1000,
    height: 400,
    scrollTo: (frame) => [frame.locator('h2', { hasText: 'Pages without a site configuration' }), 190],
  },
  'SiteHandling/SiteHandlingCreateNewSite-2': {
    module: 'site_configuration',
    width: 1000,
    height: 900,
    prepare: createSite,
    scrollTo: (frame) => [frame.locator('h1'), 180],
  },
  'SiteHandling/SiteHandlingCreateNewSite-3': {
    module: 'site_configuration',
    width: 1000,
    height: 700,
    prepare: async (context) => {
      await createSite(context);
      await context.frame.getByRole('tab', { name: 'Languages' }).click();
      // The default language opens with the form, its header is enough here
      await context.frame.locator('[role="tabpanel"]:visible .panel-heading').first().click();
      await context.page.waitForTimeout(500);
    },
    clip: (frame) => [
      frame.locator('h1'),
      frame.locator('[role="tabpanel"]:visible .panel').first(),
    ],
    margin: 6,
  },
  'SiteHandling/SiteHandlingBaseVariants-1': {
    module: 'site_configuration',
    width: 1000,
    height: 1000,
    prepare: async (context) => {
      const { page, frame } = context;
      await editSite(context);
      await frame.getByTitle('Create new').first().click();
      await siteField(frame, 'condition').waitFor();
      await fillIn(
        frame.locator('[data-formengine-input-name*="[site_base_variant]"][data-formengine-input-name$="[base]"]'),
        'https://staging.example.org/',
      );
      await fillIn(siteField(frame, 'condition'), 'applicationContext == "Development"');
      await page.waitForTimeout(1000);
    },
    scrollTo: (frame) => [frame.locator('h1'), 180],
  },
  'SiteHandling/SiteHandlingErrorHandling-1': {
    module: 'site_configuration',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      const { page, frame } = context;
      await editSite(context);
      await frame.getByRole('tab', { name: 'Error Handling' }).click();
      await frame.locator('[role="tabpanel"]:visible .panel-heading').first().click();
      // The panel opens with an animation
      await page.waitForTimeout(2000);
    },
    clip: (frame) => [
      frame.locator('h1'),
      frame.locator('[role="tabpanel"]:visible .panel').first(),
    ],
    margin: 12,
  },
  'UserManagement/Module/ModuleBackendUsers': {
    module: 'backend_user_management',
    width: 1200,
    height: 560,
    prepare: usersModulePart('Backend users'),
    mark: async ({ page, frame }) => {
      await outline(page.locator('#modulemenu a[data-modulemenu-identifier="backend_user_management"]'));
      await outline(frame.locator('.module-docheader .dropdown-toggle', { hasText: 'Module Menu' }).first());
    },
  },
  'UserManagement/Module/BackendUserGroupsModule': {
    module: 'backend_user_management',
    width: 1000,
    height: 536,
    prepare: usersModulePart('Backend user groups'),
  },
  'UserManagement/Module/FileMounts': {
    module: 'backend_user_management',
    width: 1200,
    height: 472,
    prepare: usersModulePart('File mounts'),
  },
  'UserManagement/Module/BackendUserActions': {
    module: 'backend_user_management',
    width: 1200,
    height: 700,
    prepare: async (context) => {
      const { page, frame } = context;
      await usersModulePart('Backend users')(context);
      await frame.locator('input[name*="[userName]"]').first().fill('e.doe');
      await frame.getByRole('button', { name: 'Filter' }).click();
      await frame.locator('h1').first().waitFor();
      await page.waitForTimeout(1000);
    },
    mark: async ({ frame }) => {
      const buttons = frame.locator('tr', { hasText: 'e.doe' }).locator('.col-control .btn');
      const count = await buttons.count();
      for (let index = 0; index < count; index++) {
        await badge(buttons.nth(index), index + 1);
      }
    },
    clip: (frame) => [frame.locator('table thead').first(), frame.locator('tr', { hasText: 'e.doe' })],
    margin: 6,
  },
  'UserManagement/Groups/TabGeneral': {
    module: 'backend_user_management',
    width: 1000,
    height: 700,
    prepare: createGroup,
    clip: (frame) => [frame.locator('h1'), fieldGroup(frame, 'subgroup')],
  },
  'UserManagement/Groups/TabModule': {
    module: 'backend_user_management',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Module Permissions')(context);
      for (const module of ['[dashboard]', '[web_layout]', '[records]']) {
        await context.frame.locator('tr', { hasText: module }).locator('input[type="checkbox"]').first().check();
      }
    },
    clip: (frame) => [frame.locator('h1'), frame.locator('tr', { hasText: '[page_preview]' })],
  },
  'UserManagement/Groups/TabMounts': {
    module: 'backend_user_management',
    width: 1000,
    height: 700,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Mounts')(context);
      await fieldGroup(context.frame, 'db_mountpoints').locator('input[type="search"]').first()
        .pressSequentially('Camino', { delay: 100 });
      await context.frame.locator('typo3-backend-formengine-suggest-result-item')
        .first().waitFor({ timeout: 10000 });
      await context.page.waitForTimeout(800);
    },
    keepFocus: true,
    clip: (frame) => [frame.locator('h1'), fieldGroup(frame, 'db_mountpoints')],
  },
  'UserManagement/Groups/TablePermission': {
    module: 'backend_user_management',
    width: 1300,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Record Permissions')(context);
      for (const table of ['[pages]', '[tt_content]']) {
        await context.frame.locator('tr', { hasText: table }).locator('label', { hasText: 'Read & Write' })
          .first().click();
      }
    },
    scrollTo: (frame) => [fieldGroup(frame, 'tables_select, tables_modify'), 180],
    clip: (frame) => [
      fieldGroup(frame, 'tables_select, tables_modify').locator('.form-label').first(),
      frame.locator('tr', { hasText: '[pages]' }),
    ],
    margin: 10,
  },
  'UserManagement/Groups/AllowedFields': {
    module: 'backend_user_management',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Record Permissions')(context);
      await checkItems(context, 'non_exclude_fields', 'Category', [
        '[sys_category:hidden]',
        '[sys_category:endtime]',
        '[sys_category:sys_language_uid]',
        '[sys_category:starttime]',
      ]);
    },
    scrollTo: (frame) => [fieldGroup(frame, 'non_exclude_fields'), 180],
    clip: (frame) => [
      fieldGroup(frame, 'non_exclude_fields').locator('.form-label').first(),
      fieldGroup(frame, 'non_exclude_fields').locator('tr', { hasText: '[sys_category:starttime]' }),
    ],
    margin: 10,
  },
  'UserManagement/Groups/AllowFieldValues': {
    module: 'backend_user_management',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Record Permissions')(context);
      await checkItems(context, 'explicit_allowdeny', 'Page Content: Type', [
        '[tt_content:CType:header]',
        '[tt_content:CType:text]',
        '[tt_content:CType:textpic]',
      ]);
    },
    scrollTo: (frame) => [fieldGroup(frame, 'explicit_allowdeny'), 180],
    clip: (frame) => [
      fieldGroup(frame, 'explicit_allowdeny').locator('.form-label').first(),
      fieldGroup(frame, 'explicit_allowdeny').locator('tr', { hasText: '[tt_content:CType:textpic]' }),
    ],
    margin: 10,
  },
  'UserManagement/Groups/FileMounts': {
    module: 'backend_user_management',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Mounts')(context);
      const selected = fieldGroup(context.frame, 'file_mountpoints').locator('select').first().locator('option');
      while (await selected.count() === 0) {
        await fieldGroup(context.frame, 'file_mountpoints').locator('option', { hasText: 'Camino [' }).last().click();
        await context.page.waitForTimeout(500);
      }
    },
    scrollTo: (frame) => [fieldGroup(frame, 'file_mountpoints'), 180],
    clip: (frame) => [fieldGroup(frame, 'file_mountpoints'), fieldGroup(frame, 'file_permissions')],
  },
  'UserManagement/Groups/LimitLanguages': {
    module: 'backend_user_management',
    width: 1000,
    height: 900,
    prepare: async (context) => {
      await createGroup(context);
      await openTab('Record Permissions')(context);
    },
    scrollTo: (frame) => [fieldGroup(frame, 'allowed_languages'), 180],
    clip: (frame) => [fieldGroup(frame, 'allowed_languages')],
    margin: 10,
  },
  'UserManagement/Users/TabGeneral': {
    module: 'backend_user_management',
    width: 1100,
    height: 700,
    prepare: async (context) => {
      const { page, frame } = context;
      await usersModulePart('Backend users')(context);
      await frame.locator('tr', { hasText: 'e.doe' }).getByTitle('Edit').first().click();
      await frame.locator('h1', { hasText: 'e.doe' }).waitFor();
      await page.waitForTimeout(800);
    },
    clip: (frame) => [frame.locator('h1'), fieldGroup(frame, 'usergroup')],
  },
  'UserManagement/Users/UserSettingsLanguage': {
    module: 'dashboard',
    width: 1200,
    height: 810,
    prepare: async ({ page, frame }) => {
      const userMenu = page.locator('.toolbar-item-avatar').first();
      await userMenu.click();
      await page.locator('.dropdown-menu a, .dropdown-menu button', { hasText: 'User Settings' }).first().click();
      await frame.locator('h1', { hasText: 'User Settings' }).waitFor();
      await page.waitForTimeout(800);
      await userMenu.click();
      await page.waitForTimeout(800);
    },
    // The open menu of the user would close with the focus
    keepFocus: true,
    mark: async ({ page, frame }) => {
      // The menu ends at the right edge of the window
      await badge(page.locator('.dropdown-menu a, .dropdown-menu button', { hasText: 'User Settings' }).first(), 1, 'left');
      await badge(frame.locator('select[name$="[be_users__lang]"]').first(), 2);
    },
  },
  'BackendUsers/CreateAdministrator': {
    module: 'system_maintenance',
    width: 1000,
    height: 360,
    card: 'Create Administrative User',
  },
  'BackendUsers/CreateAdministratorForm': {
    module: 'system_maintenance',
    width: 1000,
    height: 715,
    card: 'Create Administrative User',
    prepare: async (context) => {
      await openCard(context, 'Create Administrative User');
      const dialog = context.page.locator(modal);
      await dialog.locator('input[type="text"]').first().fill('x.doe');
      await dialog.locator('input[type="password"]').first().fill('Secret');
    },
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
  // Scrolls the menu from its top, so the position does not depend on the
  // screenshot before
  await link.evaluate((element) => {
    for (let parent = element.parentElement; parent; parent = parent.parentElement) {
      if (parent.scrollHeight > parent.clientHeight) {
        parent.scrollTop = 0;
      }
    }
    element.scrollIntoView({ block: 'nearest' });
  });
};

// Scrolls an element of the module to the given top, by default to the
// top of the module below its sticky header. The mouse wheel scrolls
// whichever element holds the module.
const scrollTo = async (page, element, top = 126) => {
  await page.mouse.move(600, 300);
  for (let i = 0; i < 5; i++) {
    const box = await element.boundingBox();
    if (Math.abs(box.y - top) < 2) {
      break;
    }
    await page.mouse.wheel(0, box.y - top);
    await page.waitForTimeout(300);
  }
};

// The area of the elements, with a margin around them
const area = async (elements, space = margin) => {
  const boxes = await Promise.all(elements.map((element) => element.boundingBox()));
  const x = Math.max(Math.min(...boxes.map((box) => box.x)) - space, 0);
  const y = Math.max(Math.min(...boxes.map((box) => box.y)) - space, 0);
  return {
    x,
    y,
    width: Math.max(...boxes.map((box) => box.x + box.width)) + space - x,
    height: Math.max(...boxes.map((box) => box.y + box.height)) + space - y,
  };
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
      // Admin Tools modules load their cards after the page, the other
      // modules come with their content
      const ready = screenshot.module.startsWith('system_') ? '.card' : 'h1';
      await frame.locator(ready).first().waitFor();
      await page.waitForTimeout(500);
    }
  }
  if (screenshot.prepare) {
    await screenshot.prepare({ page, frame });
    await page.waitForTimeout(500);
  }
  if (screenshot.card) {
    await scrollTo(page, frame.locator('.card', { hasText: screenshot.card }).first());
  }
  if (screenshot.scrollTo) {
    const [element, top] = screenshot.scrollTo(frame);
    await scrollTo(page, element, top);
  }
  // A hovered or focused element would look selected, except for the
  // password field that is being filled in
  await page.mouse.move(0, 0);
  if (!screenshot.fresh && !screenshot.keepFocus) {
    await page.evaluate(() => document.activeElement?.blur());
  }
  if (screenshot.mark) {
    await screenshot.mark({ page, frame });
  }
  await page.waitForTimeout(300);
  const path = `${target}/${name}.png`;
  await mkdir(dirname(path), { recursive: true });
  let image;
  if (typeof screenshot.clip === 'function') {
    // Numbered circles can stick out of the elements
    const circles = [
      ...await page.locator('.screenshot-badge').all(),
      ...await frame.locator('.screenshot-badge').all(),
    ];
    image = await page.screenshot({
      animations: 'disabled',
      clip: await area([...screenshot.clip(frame), ...circles], screenshot.margin),
    });
  } else if (screenshot.clip) {
    image = await page.screenshot({
      animations: 'disabled',
      clip: await area([page.locator(screenshot.clip).first()]),
    });
  } else {
    image = await page.screenshot({ animations: 'disabled' });
  }
  if (existsSync(path) && await changedPixels(readFileSync(path), image) < unchangedPixels) {
    console.log(`${name}.png (unchanged)`);
    return;
  }
  await writeFile(path, image);
  console.log(`${name}.png`);
};

const browser = await chromium.launch();
const page = await browser.newPage();

// A new image differs from the old one in a few pixels even when nothing
// changed, such as at the edge of a rounded corner. Below this number of
// pixels, the old image stays, so a commit holds only real changes. The
// same check as in the other manuals that take their screenshots.
const unchangedPixels = 10;
let comparison;
const changedPixels = async (before, after) => {
  comparison ??= await browser.newPage();
  return comparison.evaluate(async ([old, current]) => {
    const load = (data) => new Promise((resolve) => {
      const image = new Image();
      image.onload = () => resolve(image);
      image.src = `data:image/png;base64,${data}`;
    });
    const images = [await load(old), await load(current)];
    const { width, height } = images[0];
    if (images[1].width !== width || images[1].height !== height) {
      return Infinity;
    }
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const context = canvas.getContext('2d');
    const [a, b] = images.map((image) => {
      context.drawImage(image, 0, 0);
      return context.getImageData(0, 0, width, height).data;
    });
    let count = 0;
    for (let i = 0; i < a.length; i += 4) {
      if (Math.abs(a[i] - b[i]) + Math.abs(a[i + 1] - b[i + 1]) + Math.abs(a[i + 2] - b[i + 2]) > 30) {
        count++;
      }
    }
    return count;
  }, [before.toString('base64'), after.toString('base64')]);
};
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
