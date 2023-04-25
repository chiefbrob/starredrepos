import { teams } from './teams';
import { blog } from './blog';
import { shop } from './shop';
import { auth } from './auth';
import { system } from './system';
import { roles } from './admin/roles';
import { admin } from './admin/admin';
import { github } from './github';

const routes = [...roles, ...teams, ...blog, ...shop, ...github, ...auth, ...admin, ...system];

export default {
  mode: 'history',
  routes: routes,
};
