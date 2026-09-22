import { UrlFactory } from '@typo3/core/factory/url-factory.js';

// From a query string
const fromString = UrlFactory.createSearchParams('foo=bar&baz=qux');

// From an object
const fromObject = UrlFactory.createSearchParams({
  foo: 'bar',
  baz: 'qux',
});

// From entries, which the factory does not accept directly
const entries = [['foo', 'bar'], ['baz', 'qux']];
const fromEntries = UrlFactory.createSearchParams(
  Object.fromEntries(entries),
);
