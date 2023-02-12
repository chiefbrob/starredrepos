import { teams } from './teams';
import { blog } from './blog';
import { shop } from './shop';
import { auth } from './auth';
import { system } from './system';
import { github } from './github';

const routes = [...teams, ...blog, ...shop, ...github, ...auth, ...system];

export default {
  mode: 'history',
  routes: routes,
};
