import GithubRepositories from '../components/repos/GithubRepositories';

export const github = [
  {
    name: 'repositories',
    path: '/repositories',
    component: GithubRepositories,
    meta: { requiresAuth: true },
  },
];
